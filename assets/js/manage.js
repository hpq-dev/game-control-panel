$(document).ready(function() {
	let ID = $('#manage').data('profile');
	let dv=0;

	let search = false;
	var search_text='-1';

	var editing = false;
	var manage = false;

	let current_table=0;
	function show_table(where, userid, page_limit, search, set_page=0) {
		current_table=where;
		page = set_page == 0 ? $('#show_database_table').data('current-page') : set_page;
		$.ajax({
			url:URL + 'api/player_logs', type:'POST', data:{ID:userid, _page:page, page: page_limit, search:search, type:where},
			success:function(data) {
				$('#show_database_table').empty();
				$('#show_database_table').append(data);
				$('#show_database_table').data('current-page', page);
			}
		});
	}

	$(document).on('click', '#option-pages', function(){
		if((++dv)%2) return;
		if(!current_table)
			return;

		$('#show_database_table').data('current-page', 1);
		show_table(current_table, ID, $(this).val(), search_text);
	});

	$(document).on('click', '#logs-object', function() {
		dv = 0;
		$('#show_database_table').data('current-page', 1);
		show_table($(this).data('type'), ID, $('#option-pages').val(), search_text);
	});

	$("#search-logs").on("keyup", function() {
		if(!current_table) return;

	    var value = $(this).val().toLowerCase();
	    if(value.length) search_text = value;
	    else search_text = '-1';
	    $('#show_database_table').data('current-page', 1);
	    show_table(current_table, ID, $('#option-pages').val(), search_text);
	});

	$(document).on('click', '.page-link', function() {
		if(!$(this).data('page')) return;
		show_table(current_table, ID, $('#option-pages').val(), search_text, $(this).data('page'));
	});

	$(document).on('click', '.nav-link', function() {
		if($(this).data('manage') == 1) {
			if(manage) return true;
			$('#row-profile').hide();
			$('#row-profile-data').removeClass().addClass('col-md-6 col-xl-12');
			manage = true;
			return;
		}
		if(!manage) return;
		$('#row-profile').show();
		$('#row-profile-data').removeClass().addClass('col-md-6 col-xl-6');
		manage=false;
	});
	$(document).on('click', '#edit-notice', function() {
		if(editing) return;

		var val = $('#notice').data('info');
		$('#notice').append(
			'<div class="input-group" id="input-notice" style="margin-top:20px">' +
		        '<input type="text" class="form-control" id="notice-data" placeholder="introdu notita la acest cont" value="' + (val.length ? val : '') + '">' +
		        '<div class="input-group-append">' +
		        	'<button class="btn btn-primary" type="button" id="save-notice">SAVE</button>' +
		       	'</div>' +
		    '</div>'
		);
		editing = true;
	});
	$(document).on('click', '#save-notice', function() {
		if(!editing) return;
		$.ajax({url:URL+"api/profile", type:"POST", data:{Text: $('#notice-data').val(), ID: $('#notice').data('profile'), _token: '32vfgert45cdsf234gver'},
            success:function(result){
	           	$('.notice-data').empty();
	           	$('.notice-data').append(result);
	           	editing = false;
            }
        });
	});
});