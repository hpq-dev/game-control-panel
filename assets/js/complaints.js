
$(document).ready(function() {
    $("._type").change(function(){
        var b = $(this).children("option:selected").val();
        $('#__type').empty();
        $('#__type').append('Motiv <i class="fa fa-spinner fa-spin fa-fw _lr" style></i>');
        $('._reason').attr('disabled','');
        $.ajax({url:URL+"api/complaints", type:"POST", data:{a:b},
            success:function(result){
                $('._reason').empty();
                $('._reason').append(result);
                $('#__type').empty();
                $('#__type').append('Motiv');
                $('._reason').attr('disabled',false);
            }
        });
    });
});

$('._acc').click((a) => {
    $('._acc').removeClass('active');
    $(a.target).addClass('active');
    $('input[name="_access"]').val(a.target.name);
});