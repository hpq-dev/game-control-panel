$(document).ready(function() {
    var total=$('.row-items').data('already-questions');
    var start=$('.row-items').data('question-start');

    $(document).on('click', '#delete-question', function(){
        var remove_id = $(this).data('remove-id');
        $.post(URL + 'api/leader/remove', {question_id: $(this).data('remove-id'), _token: 'ec19a477499f637e9716131f33097b67'}, 
            function(result){
            $('#question-id-' + remove_id).remove();
            --total,--start;
            alertify.notify('Ai sters o intrebare!', 'error');
        });
    });
    $(document).on('click', '#add-question', function() {
        if(total>=15) return;
        total++;
        alertify.notify('Ai adaugat o intrebare noua!', 'success');
        $('.row-items').append(
        '<div class="input-group mb-3">' +
            '<input type="text" class="form-control" id="new-question-id-' + total + '" placeholder="Add here your new question" aria-describedby="basic-addon2">' +
        '</div>'
        );
    });
    $(document).on('click', '#save-questions', function() {
        for(var i=start;i<15;++i) {
            if($('#new-question-id-' + i)[0]) {
                if($('#new-question-id-' + i).val().length < 1) continue;
                $.post(URL + 'api/leader/save', {
                    ID: $('.main-body').data('group'), Text: $('#new-question-id-' + i).val(), _token: 'ec19a477499f637e9716131f33097b67'
                });
            }
        }
        window.location.href = URL + 'leader';
    });
    $(document).on('click', '#change-status', function() {
        $status = $('#change-status').data('value') == 0 ? 1 : 0;
        $.post(URL + 'api/leader/toggle', {Toggle: $status, Faction: $('.main-body').data('group'), _token: 'ec19a477499f637e9716131f33097b67'}, function(result){
            if(result != 's404') {
                alertify.notify($status ? 'Ai deschis aplicatiile!' : 'Ai inchis aplicatiile!', $status ? 'success' : 'error');
                $('#change-status').remove();
                $('#status-changes').append(result);
            }
        });
    });
    $(document).on('click', '#save-app', function() {
        alertify.notify('Modificarile au fost salavate!', 'success');
        var level = $('#save-input').val(); 
        if(level < 1 || level > 20) return;
        $.post(URL + 'api/leader/update', {Level: $('#save-input').val(), Faction: $('.main-body').data('group'), _token: 'ec19a477499f637e9716131f33097b67'}, function(result){
        });
    });
});