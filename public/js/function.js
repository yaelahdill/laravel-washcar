function createTable(data, url, element, name){
    $.ajax({
        type: 'GET',
        url: url,
        data: data,
        beforeSend: function(){
            disabled_element();
            $(element).html('<div class="text-center" style="margin: 20px;"><div class="spinner-border text-primary" role="status"></div></div>');
        },success: function(result){
            enable_element();
            $(element).html(result);

            $('#page-list').on('click', '#page', function(e){
                e.preventDefault();
                const page = $(this).data('id');
                // localStorage.setItem(`page-${name}`, page);
                data.page = page;
                createTable(data, url, element, name);
            });

            $('#nextPage').on('click', function(e){
                e.preventDefault();
                const page = $('#nextPage').data('id');
                // localStorage.setItem(`page-${name}`, page);
                data.page = page;
                createTable(data, url, element, name);
            });

            $('#prevPage').on('click', function(e){
                e.preventDefault();
                const page = $('#prevPage').data('id');
                // localStorage.setItem(`page-${name}`, page);
                data.page = page;
                createTable(data, url, element, name);
            });

        }, error: function(){
            enable_element();
            $(element).html('<div class="text-center" style="margin: 20px;">Something went wrong!</div>');
        }
    });
}

function disabled_element(){
    $("input").attr('disabled','disabled');
    $("select").attr('disabled','disabled');
    $("textarea").attr('disabled','disabled');
    $("button").attr('disabled','disabled');
}

function enable_element(){
    $("input").removeAttr('disabled');
    $("select").removeAttr('disabled');
    $("button").removeAttr('disabled');
    $("textarea").removeAttr('disabled');
}