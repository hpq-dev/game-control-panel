$(document).ready(function() {
	function Final(value) {
		if(value < 1) value = '';
		if(value > 999) value = 999;

		if(value) {
			var euro = 4.95;
			$('#amount').val(value);
			$('#you').html('You get <b>' + (value*50) + '</b> premium points for <b>' + value + '</b> EUR (~' + (value * euro) + ' RON).').show();
			$('button').attr('disabled',false);
		} else {
			$('#you').hide();
			$('button').attr('disabled',true);
		}
	}
	$('#amount').on('keyup', () => Final($('#amount').val()));
	$('#amount').change(() => Final($('#amount').val()));
});