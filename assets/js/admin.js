$(document).ready(function() {
    var total = new Array(2);
    var start = new Array(2);
    total[0] =$('.row-items-0').data('already-questions');
    total[1] =$('.row-items-1').data('already-questions');
    start[0] =$('.row-items-0').data('question-start');
    start[1] =$('.row-items-1').data('question-start');

    $(document).on('click', '#delete-question', function(){
        var remove_id = $(this).data('remove-id');
        let type = $(this).data('val');
        $.post(URL + 'api/admin/remove', {question_id: $(this).data('remove-id'), _token: 'ec19a477499f637e9716131f33097b67'}, 
            function(result){
            $('#question-id-' + remove_id).remove();
            --total[type],--start[type];
            alertify.notify('Ai sters o intrebare!', 'error');
        });
    });
    $(document).on('click', '#add-question', function() {
        let type = $(this).data('val');
        if(total[type]>=15) return;
        total[type]++;
        alertify.notify('Ai adaugat o intrebare noua!', 'success');
        $('.row-items-' + type).append(
        '<div class="input-group mb-3">' +
            '<input type="text" class="form-control" id="new-question-id-' + total[type] + '-' + type + '" placeholder="Add here your new question" aria-describedby="basic-addon2">' +
        '</div>'
        );
    });
    $(document).on('click', '#save-questions', function() {
        let type = $(this).data('val');
        for(var i=start[type];i<15;++i) {
            if($('#new-question-id-' + i + '-' + type)[0]) {
                if($('#new-question-id-' + i + '-' + type).val().length < 1) continue;
                $.post(URL + 'api/admin/save', {
                    ID: $('.main-body').data('group'), Text: $('#new-question-id-' + i + '-' + type).val(), Type:type, _token: 'ec19a477499f637e9716131f33097b67'
                }, function(result){
                    window.location.href = URL + 'admin';
                });
            }
        }
    });
    $(document).on('click', '.change-status', function() {
        i = $(this).data('val');
        $status = $('#change-status-' + i).data('value') == 0 ? 1 : 0;
        $.post(URL + 'api/admin/toggle', {Toggle: $status, ID:i, _token: 'ec19a477499f637e9716131f33097b67'}, function(result){
            if(i==0) alertify.notify($status ? 'Ai deschis aplicatiile pentru helper!' : 'Ai inchis aplicatiile pentru helper!', $status ? 'success' : 'error');
            else alertify.notify($status ? 'Ai deschis aplicatiile pentru leader!' : 'Ai inchis aplicatiile pentru leader!', $status ? 'success' : 'error');
            $('#change-status-' + i).remove();
            $('#status-changes-' + i).append(result);
        });
    });
});