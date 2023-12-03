$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

function createTable(data, url, element, name) {
    $.ajax({
        type: "GET",
        url: url,
        data: data,
        beforeSend: function () {
            disabled_element();
            $(element).html(
                '<div class="text-center" style="margin: 20px;"><div class="spinner-border text-primary" role="status"></div></div>'
            );
        },
        success: function (result) {
            enable_element();
            $(element).html(result);

            $("#page-list").on("click", "#page", function (e) {
                e.preventDefault();
                const page = $(this).data("id");
                // localStorage.setItem(`page-${name}`, page);
                data.page = page;
                createTable(data, url, element, name);
            });

            $("#nextPage").on("click", function (e) {
                e.preventDefault();
                const page = $("#nextPage").data("id");
                // localStorage.setItem(`page-${name}`, page);
                data.page = page;
                createTable(data, url, element, name);
            });

            $("#prevPage").on("click", function (e) {
                e.preventDefault();
                const page = $("#prevPage").data("id");
                // localStorage.setItem(`page-${name}`, page);
                data.page = page;
                createTable(data, url, element, name);
            });
        },
        error: function () {
            enable_element();
            $(element).html(
                '<div class="text-center" style="margin: 20px;">Something went wrong!</div>'
            );
        },
    });
}

function curl_post(url, data, redirect = true) {
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        beforeSend: function () {
            disabled_element();
        },
        success: function (data) {
            enable_element();
            if (data.result == true) {
                alert_success(data.message);

                if (redirect) {
                    if (data.redirect) {
                        window.setTimeout(function () {
                            window.location.replace(data.redirect);
                        }, 1000);
                    } else {
                        window.setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                }
            } else {
                alert_error(data.message);
            }
        },
        error: function (xhr, status, error) {
            enable_element();
            alert_error(`Xhr Error : ${xhr} , Error : ${error.message}`);
        },
    });

    return true;
}

function curl_post_image(url, data, redirect = true) {
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
            disabled_element();
        },
        success: function (data) {
            enable_element();
            if (data.result == true) {
                alert_success(data.message);
                if (redirect) {
                    if (data.redirect) {
                        window.setTimeout(function () {
                            window.location.replace(data.redirect);
                        }, 1000);
                    } else {
                        window.setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                }
            } else {
                alert_error(data.message);
            }
        },
        error: function () {
            enable_element();
            alert_error("System Error");
        },
    });

    return true;
}

function alert_success(message) {
    Swal.fire({
        icon: "success",
        title: "Success",
        text: message,
    });
}

function alert_error(message) {
    Swal.fire({
        icon: "error",
        title: "Error",
        text: message,
    });
}

function swal_confirm(title, message, url, data) {
    Swal.fire({
        title: title,
        html: message,
        showCancelButton: true,
        confirmButtonText: "Submit",
        cancelButtonText: "Close",
    }).then((result) => {
        if (result.isConfirmed) {
            curl_post(url, data);
        }
    });
    return true;
}

function disabled_element() {
    $("input").attr("disabled", "disabled");
    $("select").attr("disabled", "disabled");
    $("textarea").attr("disabled", "disabled");
    $("button").attr("disabled", "disabled");
}

function enable_element() {
    $("input").removeAttr("disabled");
    $("select").removeAttr("disabled");
    $("button").removeAttr("disabled");
    $("textarea").removeAttr("disabled");
}
