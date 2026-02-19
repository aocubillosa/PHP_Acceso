$(document).ready( function() {

	$("#firstName").bloquearNumeros().maxlength(50);
	$("#lastName").bloquearNumeros().maxlength(50);
	$("#movilNumber").bloquearTexto().maxlength(10);
	$("#numeroDocumento").bloquearTexto().maxlength(10);
	
	$( "#form" ).validate( {
		rules: {
			tipoDocumento: 		{ required: true },
			numeroDocumento: 	{ required: true },
			firstName: 			{ required: true, minlength: 3, maxlength:50 },
			lastName: 			{ required: true, minlength: 3, maxlength:50 },
			tipoFuncionario: 	{ required: true },
			email: 				{ required: true, email: true },
			movilNumber: 		{ required: true }
		},
		errorElement: "em",
		errorPlacement: function ( error, element ) {
			error.addClass( "help-block" );
			error.insertAfter( element );
		},
		highlight: function ( element, errorClass, validClass ) {
			$( element ).parents( ".col-sm-4" ).addClass( "has-error" ).removeClass( "has-success" );
		},
		unhighlight: function (element, errorClass, validClass) {
			$( element ).parents( ".col-sm-4" ).addClass( "has-success" ).removeClass( "has-error" );
		},
		submitHandler: function (form) {
			return true;
		}
	});
	
	$("#btnSubmit").click(function(){
		if ($("#form").valid() == true){
			$('#btnSubmit').attr('disabled','-1');
			$("#div_error").css("display", "none");
			$("#div_load").css("display", "inline");
			$.ajax({
				type: "POST",
				url: base_url + "settings/save_employee",
				data: $("#form").serialize(),
				dataType: "json",
				contentType: "application/x-www-form-urlencoded;charset=UTF-8",
				cache: false,
				success: function(data){
					if(data.result == "error")
					{
						$("#div_load").css("display", "none");
						$("#div_error").css("display", "inline");
						$("#span_msj").html(data.mensaje);
						$('#btnSubmit').removeAttr('disabled');
						return false;
					} 
					if(data.result)
					{
						$("#div_load").css("display", "none");
						$('#btnSubmit').removeAttr('disabled');
						var url = base_url + "settings/employees/" + data.state;
						$(location).attr("href", url);
					}
					else
					{
						alert('Error. Reload the web page.');
						$("#div_load").css("display", "none");
						$("#div_error").css("display", "inline");
						$('#btnSubmit').removeAttr('disabled');
					}	
				},
				error: function(result) {
					alert('Error. Reload the web page.');
					$("#div_load").css("display", "none");
					$("#div_error").css("display", "inline");
					$('#btnSubmit').removeAttr('disabled');
				}
			});
		}
	});
});

$(function(){ 
	$(".btn-success").click(function () {
		var oID = $(this).attr("id");
        $.ajax ({
            type: 'POST',
			url: base_url + '/settings/cargarModalEmployees',
            data: {'idEmployee': oID},
            cache: false,
            success: function (data) {
                $('#tablaDatos').html(data);
            }
        });
	});	
});