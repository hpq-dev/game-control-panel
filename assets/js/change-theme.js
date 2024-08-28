$(document).ready(() => {
    $(document).on('click', '.change-theme', function() {
        let x = $('#theme').data('theme');
        $.ajax({url: URL + 'api/theme', type:'POST',data:{status:x},
            success:function(a) {
                if(!x) $("#theme").attr({href: URL + "assets/css/style-dark.css"}), x = 1;
                else $("#theme").attr({href: URL + "assets/css/style.css"}), x = 0;

                $('#theme').data('theme', x);
                if(x) $('.change-theme').empty(), $('.change-theme').append('<i class="feather icon-eye-off">');
                else $('.change-theme').empty(), $('.change-theme').append('<i class="feather icon-eye">');
            }
        });
    });
});