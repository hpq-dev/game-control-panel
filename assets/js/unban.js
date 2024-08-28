$(document).ready(function() {
	var editing = false;
	$(document).on('click', '#edit-text', function() {
		if(editing) return;

		let i = $(this).data('id');

		var val = $('#media-' + i).data('info');
		$('#media-' + i).append(
			'<div class="mt-0 mb-1 mt-2">' +
				'<div class="input-group" id="input-notice" style="margin-top:20px">' +
			        '<input type="text" class="form-control" id="notice-data-' + i + '" placeholder="introdu notita la acest cont" value="' + val + '">' +
			        '<div class="input-group-append">' +
			        	'<button class="btn btn-primary" type="button" id="save-notice" data-id="' + i + '">SAVE</button>' +
			       	'</div>' +
			    '</div>' +
			'</div>'
		);
		editing = true;
	});
	$(document).on('click', '#save-notice', function() {
		if(!editing) return;

		let i = $(this).data('id');
		$.ajax({url:URL+"api/update-comment-ban", type:"POST", data:{Text: $('#notice-data-' + i).val(), ID: i, Type: $('#media-' + i).data('type'), _token: '32vfgert45cdsf234gver'},
            success:function(result){
            	console.log(result);
	           	$('#media-' + i).empty();
	           	$('#media-' + i).append(result);
	           	editing = false;
            }
        });
	});
	$(document).on('click', '#delete-text', function() {
		let i = $(this).data('id');
		$.ajax({url:URL+"api/remove-ban-comment", type:"POST", data:{ID: i, _token: '54yfdgfdg34rerg'},
            success:function(result){
	           	$('#main-media-' + i).remove();
            }
        });
	});
});