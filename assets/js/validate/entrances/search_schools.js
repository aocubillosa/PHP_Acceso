$(document).ready( function() {

	$("#nit").bloquearTexto().maxlength(10);
	
	$( "#form" ).validate( {
		rules: {
			nit: 		{ required: true, maxlength: 10 },
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
				url: base_url + "entrances/verifySchool",
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
						if (data.estado)
						{
							if (data.members)
							{
								$("#div_load").css("display", "none");
								$('#btnSubmit').removeAttr('disabled');
								var url = base_url + "settings/members/" + data.idSchool + '/1';
								$(location).attr("href", url);
							}
							else
							{
								$("#div_load").css("display", "none");
								$("#div_error").css("display", "inline");
								$('#btnSubmit').removeAttr('disabled');
								Swal.fire({
									title: "Escuelas",
						            text: "La escuela no tiene integrantes, ¿desea cargarlos?",
						            icon: "warning",
						            confirmButtonText: "Confirmar",
						            showCancelButton: true,
						            cancelButtonColor: "#DD6B55",
						            allowOutsideClick: false,
									allowEscapeKey: false
								}).then((result) => {
									if (result.isConfirmed) {
										var url = base_url + "settings/schools";
										$(location).attr("href", url);
									}
								});
							}
						}
						else
						{
							$("#div_load").css("display", "none");
							$("#div_error").css("display", "inline");
							$('#btnSubmit').removeAttr('disabled');
							Swal.fire({
								title: "Escuelas",
					            text: "La escuela está inactiva, ¿desea activarla?",
					            icon: "warning",
					            confirmButtonText: "Confirmar",
					            showCancelButton: true,
					            cancelButtonColor: "#DD6B55",
					            allowOutsideClick: false,
								allowEscapeKey: false
							}).then((result) => {
								if (result.isConfirmed) {
									var url = base_url + "settings/schools/2";
									$(location).attr("href", url);
								}
							});
						}
					}
					else
					{
						$("#div_load").css("display", "none");
						$("#div_error").css("display", "inline");
						$('#btnSubmit').removeAttr('disabled');
						Swal.fire({
							title: "Escuelas",
				            text: "La escuela no está registrada, ¿desea registrarla?",
				            icon: "warning",
				            confirmButtonText: "Confirmar",
				            showCancelButton: true,
				            cancelButtonColor: "#DD6B55",
				            allowOutsideClick: false,
							allowEscapeKey: false
						}).then((result) => {
							if (result.isConfirmed) {
								var url = base_url + "settings/schools";
								$(location).attr("href", url);
							}
						});
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