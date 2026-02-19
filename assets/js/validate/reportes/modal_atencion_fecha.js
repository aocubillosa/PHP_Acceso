$(document).ready(function() {

	$(function() {
		var rangoFechas = $('#from, #to').datepicker({
	        changeMonth: true,
	        changeYear: true,
	        dateFormat: 'yy-mm-dd',
	        numberOfMonths: 1,
	        onSelect: function (selectedDate) {
	            var option = this.id == 'from' ? 'minDate' : 'maxDate',instance = $(this).data('datepicker');
	            date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
	            rangoFechas.not(this).datepicker('option', option, date);
	        }
	    });
    });
	
	$("#form").validate( {
		rules: {
			from: 		{ required: true },
			to: 		{ required: true }
		},
		errorElement: "em",
		errorPlacement: function ( error, element ) {
			error.addClass( "help-block" );
			error.insertAfter( element );
		},
		highlight: function ( element, errorClass, validClass ) {
			$( element ).parents( ".col-sm-6" ).addClass( "has-error" ).removeClass( "has-success" );
		},
		unhighlight: function (element, errorClass, validClass) {
			$( element ).parents( ".col-sm-6" ).addClass( "has-success" ).removeClass( "has-error" );
		},
		submitHandler: function (form) {
			return true;
		}
	});
	
	$("#btnSubmit").click(function(){
		if ($("#form").valid() == true){
			var form = document.getElementById('form');
			form.submit();
		}
	});
});