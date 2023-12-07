<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Merchant;
use App\Models\Notification;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'result' => true,
            'data' => [
                'user' => [
                    'id' => $request->user()->id,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                    'phone' => $request->user()->phone,
                ],
                'banners' => $this->banners(),
                'merchants' => $this->merchants(),
                // 'notifications' => $this->notifications($request->user()->id),
            ]
        ]);
    }

    public function notification(Request $request){
        return response()->json([
            'result' => true,
            'data' => $this->notifications($request->user()->id)
        ]);
    }

    public function list_merchant(Request $request){
        return response()->json([
            'result' => true,
            'data' => $this->merchants()
        ]);
    }

    function banners(){
        $query = Banner::query();

        $query->latest();

        $banners = $query->get();
        $array = [];
        
        foreach ($banners as $banner) {
            $array[] = [
                'id' => $banner->id,
                'title' => $banner->title,
                'image' => asset('images/banner/' . $banner->image),
                'created_at' => $banner->created_at->diffForHumans(),
            ];
        }

        return $array;
    }

    function merchants(){
        $query = Merchant::query();

        $merchants = $query->get();
        $array = [];

        foreach ($merchants as $merchant) {
            $array[] = [
                'id' => $merchant->id,
                'name' => $merchant->name,
                'email' => $merchant->email,
                'phone' => $merchant->phone,
                'address' => $merchant->address,
                'city' => $merchant->city,
                'opening_hours' => $merchant->opening_hours,
                'latitude' => $merchant->latitude,
                'longitude' => $merchant->longitude,
                'created_at' => $merchant->created_at->diffForHumans(),
            ];
        }

        return $array;
    }

    function notifications($user_id){
        $query = Notification::query();
        $query->where('user_id', $user_id);
        $query->limit(20);

        $notifications = $query->get();
        $array = [];

        foreach ($notifications as $notification) {
            $array[] = [
                'id' => $notification->id,
                'title' => $notification->title,
                'message' => $notification->message,
                'is_read' => $notification->is_read,
                'created_at' => $notification->created_at->diffForHumans(),
            ];
        }

        return $array;
    }
}
