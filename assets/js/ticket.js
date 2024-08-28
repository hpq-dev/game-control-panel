$(document).ready(function() {
	var editing = false, current_edit=-1;
	$(document).on('click', '#edit-text', function() {
		let i = $(this).data('id');
		if(current_edit!=i) {
			$('#input-notice').remove();
			editing=false;
		}
		if(!editing) {
			current_edit = i;
			var val = $('#media-' + i).data('info');

			$.ajax({url:URL+"api/show_input", type:"POST", data:{ID:i,val:val},
	            success:function(result){
					$('#media-' + i).append(result);
	            }
	        });
	        editing=true;
		} else {
			$('#input-notice').remove();
			editing=false;
		}
	});
	$(document).on('click', '#save-notice', function() {
		if(!editing) return;

		let i = $(this).data('id');
		$.ajax({url:URL+"api/update-comment/ticket", type:"POST", data:{Text: $('#notice-data-' + i).val(), ID: i},
            success:function(result){
            	$('#media-' + i).data('info', $('#notice-data-' + i).val());
	           	$('#media-' + i).empty();
	           	$('#media-' + i).append(result);
	           	editing = false;
            }
        });
	});
	$(document).on('click', '#delete-text', function() {
		let i = $(this).data('id');
		$.ajax({url:URL+"api/update-comment/ticket/delete", type:"POST", data:{ID: i},
            success:function(result){
	           	$('#main-media-' + i).remove();
	           	alertify.success('Mesajul a fost sters!');
            }
        });
	});
});