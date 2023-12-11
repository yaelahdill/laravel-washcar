<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\OrderService;
use App\Models\OrderVehicle;
use App\Models\Service;
use App\Models\Vehicle;
use App\Models\Voucher;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request $request){
        $query = Order::query();
        $query->with('merchant','vehicle','services','payment');
        $query->where('user_id', $request->user()->id);

        $query->when($request->status, function($q) use ($request){
            $q->where('status', $request->status);
        });
        $query->when($request->invoice, function($q) use ($request){
            $q->where('invoice', 'like', '%'.$request->invoice.'%');
        });

        $query->latest();

        $list = $query->paginate(10);
        $array = [];

        foreach($list as $item){
            $array[] = [
                'id' => $item->id,
                'invoice' => $item->invoice,
                'subtotal' => "Rp" . number_format($item->subtotal, 0, '.', '.'),
                'total' => "Rp" . number_format($item->total, 0, '.', '.'),
                'status' => $item->showStatus(),
                'voucher' => [
                    'code' => $item->voucher,
                    'discount' => "Rp" . number_format($item->discount, 0, '.', '.'),
                ],
                'merchant' => [
                    'name' => $item->merchant?->name,
                    'email' => $item->merchant?->email,
                    'phone' => $item->merchant?->phone,
                    'address' => $item->merchant?->address,
                    'city' => $item->merchant?->city,
                    'latitude' => $item->merchant?->latitude,
                    'longitude' => $item->merchant?->longitude,
                    'opening_hours' => $item->merchant?->opening_hours,
                ],
                'vehicle' => [
                    'plate_number' => $item->vehicle?->plate_number,
                    'category' => $item->vehicle?->category,
                    'size' => $item->vehicle?->size,
                    'brand' => $item->vehicle?->brand,
                ],
                'payment' => [
                    'method' => $item->payment?->payment_method,
                    'name' => $item->payment?->payment_name,
                    'transaction_id' => $item->payment?->transaction_id,
                ],
                'services' => $item->services->map(function($service){
                    return [
                        'name' => $service->name,
                        'description' => $service->description,
                        'estimated_time' => $service->estimated_time,
                        'price' => $service->price,
                    ];
                }),
                'created_at' => $item->created_at->format('d M Y H:i:s'),
                'updated_at' => $item->updated_at->format('d M Y H:i:s'),
            ];
        }

        return response()->json([
            'result' => true,
            'message' => 'ok',
            'data' => $array,
            'pagination' => [
                'current_page' => $list->currentPage(),
                'last_page' => $list->lastPage(),
                'total' => $list->total(),
                'per_page' => $list->perPage(),
            ]
        ]);

    }

    public function get_services(Request $request){
        $validator = Validator::make($request->all(), [
            'merchant_id' => 'required|exists:merchants,id', 
            'vehicle_id' => 'required|exists:vehicles,id',
        ],[
            'merchant_id.required' => 'ID merchant tidak boleh kosong',
            'merchant_id.exists' => 'Merchant tidak ditemukan',
            'vehicle_id.required' => 'ID kendaraan tidak boleh kosong',
            'vehicle_id.exists' => 'Kendaraan tidak ditemukan',
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $vehicle = Vehicle::where([
            'user_id' => $request->user()->id,
            'id' => $request->vehicle_id
        ])->first();
        if(!$vehicle){
            return response()->json([
                'result' => false,
                'message' => "Kendaraan tidak ditemukan"
            ]);
        }

        $services = Service::where([
            'merchant_id' => $request->merchant_id,
            'vehicle_category' => $vehicle->category,
            'vehicle_size' => $vehicle->size
        ])->latest()->get();
        $array = [];

        foreach($services as $service){
            $array[] = [
                'id' => $service->id,
                'name' => $service->name,
                'description' => $service->description,
                'estimated_time' => $service->estimated_time,
                'price' => $service->price,
                'size' => $service->vehicle_size,
            ];
        }

        return response()->json([
            'result' => true,
            'message' => 'ok',
            'data' => $array
        ]);
    }

    public function checkVoucher(Request $request){
        $validator = Validator::make($request->all(), [
            'merchant_id' => 'required|exists:merchants,id', 
            'voucher' => 'required|string',
        ],[
            'merchant_id.required' => 'ID merchant tidak boleh kosong',
            'merchant_id.exists' => 'Merchant tidak ditemukan',
            'voucher.required' => 'Voucher tidak boleh kosong',
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $voucher = Voucher::with('usage')->where([
            'merchant_id' => $request->merchant_id,
            'code' => $request->voucher,
        ])->first();
        if(!$voucher){
            return response()->json([
                'result' => false,
                'message' => 'Voucher tidak ditemukan'
            ]);
        } else if(!$voucher->is_active){
            return response()->json([
                'result' => false,
                'message' => 'Voucher sudah tidak aktif'
            ]);
        } else if($voucher->start_date > date('Y-m-d')){
            return response()->json([
                'result' => false,
                'message' => 'Voucher Belum dapat digunakan'
            ]);
        } else if($voucher->expired_at < date('Y-m-d')){
            return response()->json([
                'result' => false,
                'message' => 'Voucher telah kadaluarsa'
            ]);
        } else if($voucher->quantity <= $voucher->usage?->count()){
            return response()->json([
                'result' => false,
                'message' => 'Voucher telah habis'
            ]);
        } else {
            return response()->json([
                'result' => true,
                'message' => 'Voucher berhasil digunakan [ ' . number_format($voucher->discount, 0, '.', '.') . ' ])',
                'data' => [
                    'name' => $voucher->name,
                    'code' => $voucher->code,
                    'discount' => $voucher->discount,
                ]
            ]);
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'merchant_id' => 'required|integer|exists:merchants,id',
            'vehicle_id' => 'required|integer|exists:vehicles,id',
            'service_ids' => 'required|array',
            'payment_method' => 'required|string',
            'voucher' => 'nullable|string',
        ],[
            'merchant_id.required' => 'ID merchant tidak boleh kosong',
            'merchant_id.exists' => 'Merchant tidak ditemukan',
            'vehicle_id.required' => 'ID kendaraan tidak boleh kosong',
            'vehicle_id.exists' => 'Kendaraan tidak ditemukan',
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $vehicle = Vehicle::where([
            'user_id' => $request->user()->id,
            'id' => $request->vehicle_id
        ])->first();
        if(!$vehicle){
            return response()->json([
                'result' => false,
                'message' => "Kendaraan tidak ditemukan"
            ]);
        }

        $merchant = Merchant::where([
            'id' => $request->merchant_id
        ])->first();

        $discount = 0;
        $subtotal = 0;

        try {
            DB::beginTransaction();

            $voucher = null;
            //Validation Voucher
            if(!empty($request->voucher)){
                $voucher = Voucher::with('usage')->where([
                    'code' => $request->voucher,
                ])->first();
                if(!$voucher){
                    return response()->json([
                        'result' => false,
                        'message' => 'Voucher tidak ditemukan'
                    ]);
                } else if($voucher->merchant_id && $voucher->merchant_id !== $merchant->id){
                    return response()->json([
                        'result' => false,
                        'message' => 'Voucher tidak dapat digunakan di merchant ini'
                    ]);
                } else if($voucher->status !== '1'){
                    return response()->json([
                        'result' => false,
                        'message' => 'Voucher tidak dapat digunakan'
                    ]);
                } else if($voucher->start_date > date('Y-m-d')){
                    return response()->json([
                        'result' => false,
                        'message' => 'Voucher belum dapat digunakan'
                    ]);
                } else if($voucher->expired_at < date('Y-m-d')){
                    return response()->json([
                        'result' => false,
                        'message' => 'Voucher telah kadaluarsa'
                    ]);
                } else if($voucher->quantity <= $voucher->usage?->count()){
                    return response()->json([
                        'result' => false,
                        'message' => 'Voucher telah habis'
                    ]);
                } else {
                    $discount = $voucher->discount;
                }
            }
            //End Validation Voucher

            $invoice = "INV/" . date('Ymd') . "/" . rand(1000, 9999);

            $order = Order::create([
                'user_id' => $request->user()->id,
                'merchant_id' => $request->merchant_id,
                'invoice' => $invoice,
                'voucher_id' => ($voucher) ? $voucher->id : null,
                'voucher' => ($voucher) ? $voucher->code : null,
                'discount' => $discount,
                'status' => '1',
            ]);
       
            $services = Service::whereIn('id', $request->service_ids)->where('merchant_id', $request->merchant_id)->get();

            foreach($services as $service){
                OrderService::create([
                    'order_id' => $order->id,
                    'service_id' => $service->id,
                    'name' => $service->name,
                    'type' => $service->vehicle_size,
                    'description' => $service->description,
                    'estimated_time' => $service->estimated_time,
                    'price' => $service->price,
                ]);
                $subtotal += $service->price;
            }

            $total = $subtotal - $discount;
            $order->update([
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,
            ]);

            $payment = OrderPayment::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
            ]);

            OrderVehicle::create([
                'order_id' => $order->id,
                'vehicle_id' => $vehicle->id,
                'plate_number' => $vehicle->plate_number,
                'category' => $vehicle->category,
                'size' => $vehicle->size,
                'brand' => $vehicle->brand,
            ]);

            DB::commit();
            return response()->json([
                'result' => true,
                'message' => 'Sukses membuat order',
                'data' => [
                    'invoice' => $invoice,
                    'merchant' => $merchant,
                    'vehicle' => $vehicle,
                    'services' => $services,
                    'payment' => $payment,
                ]
            ]);
        } catch (Exception $e){
            Log::error($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());
            DB::rollback();
            return response()->json([
                'result' => false,
                'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()
            ]);
        }
    }

    public function detail(Request $request){
        $validator = Validator::make($request->all(), [
            'invoice' => 'required|string|exists:orders,invoice',
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $order = Order::with('user','merchant','services','payment','vehicle')->where([
            'invoice' => $request->invoice,
            'user_id' => $request->user()->id
        ])->first();
        if(!$order){
            return response()->json([
                'result' => false,
                'message' => 'Order tidak ditemukan'
            ]);
        }

        return response()->json([
            'result' => true,
            'message' => 'ok',
            'data' => [
                'invoice' => $order->invoice,
                'status' => $order->showStatus(),
                'subtotal' => "Rp" . number_format($order->subtotal, 0, '.', '.'),
                'total' => "Rp" . number_format($order->total, 0, '.', '.'),
                'discount' => "Rp" . number_format($order->discount, 0, '.', '.'),
                'created_at' => $order->created_at->format('d M Y H:i:s'),
                'customer' => [
                    'name' => $order->user?->name,
                    'email' => $order->user?->email,
                    'phone' => $order->user?->phone,
                ],
                'voucher' => [
                    'code' => $order->voucher,
                    'discount' => $order->discount,
                ],
                'merchant' => [
                    'name' => $order->merchant?->name,
                    'email' => $order->merchant?->email,
                    'phone' => $order->merchant?->phone,
                    'address' => $order->merchant?->address,
                    'city' => $order->merchant?->city,
                ],
                'payment' => [
                    'method' => $order->payment?->payment_method,
                    'name' => $order->payment?->payment_name,
                    'transaction_id' => $order->payment?->transaction_id,
                ],
                'vehicle' => [
                    'plate_number' => $order->vehicle?->plate_number,
                    'category' => $order->vehicle?->category,
                    'size' => $order->vehicle?->size,
                    'brand' => $order->vehicle?->brand,
                ],
                'services' => $order->services->map(function($service){
                    return [
                        'name' => $service->name,
                        'description' => $service->description,
                        'estimated_time' => $service->estimated_time,
                        'price' => $service->price,
                    ];
                })
            ]
        ]);
    }
}
