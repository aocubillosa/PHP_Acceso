$(document).ready( function() {

	$("#documento").bloquearTexto().maxlength(10);
	
	$( "#form" ).validate( {
		rules: {
			documento: 		{ required: true, maxlength: 10 },
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
		var documento = $('#documento').val();
		if ($("#form").valid() == true){
			$('#btnSubmit').attr('disabled','-1');
			$("#div_error").css("display", "none");
			$("#div_load").css("display", "inline");
			$.ajax({
				type: "POST",
				url: base_url + "entrances/verifyVisitor",
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
							if (data.ingreso)
							{
								$("#div_load").css("display", "none");
								$("#div_error").css("display", "inline");
								$('#btnSubmit').removeAttr('disabled');
								Swal.fire({
									title: "Visitantes",
						            text: "El visitante ya tiene acceso.",
						            icon: "success",
						            confirmButtonText: "Confirmar",
						            allowOutsideClick: false,
									allowEscapeKey: false
								}).then((result) => {
									if (result.isConfirmed) {
										var url = base_url + "entrances/searchVisitors";
										$(location).attr("href", url);
									}
								});
							}
							else
							{
								$("#div_load").css("display", "none");
								$('#btnSubmit').removeAttr('disabled');
								var url = base_url + "entrances/generateAccess/" + documento + "/2";
								$(location).attr("href", url);
							}
						}
						else
						{
							$("#div_load").css("display", "none");
							$("#div_error").css("display", "inline");
							$('#btnSubmit').removeAttr('disabled');
							Swal.fire({
								title: "Visitantes",
					            text: "El visitante está inactivo, ¿desea activarlo?",
					            icon: "warning",
					            confirmButtonText: "Confirmar",
					            showCancelButton: true,
					            cancelButtonColor: "#DD6B55",
					            allowOutsideClick: false,
								allowEscapeKey: false
							}).then((result) => {
								if (result.isConfirmed) {
									var url = base_url + "settings/visitors/2";
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
							title: "Visitantes",
				            text: "El visitante no está registrado, ¿desea registrarlo?",
				            icon: "warning",
				            confirmButtonText: "Confirmar",
				            showCancelButton: true,
				            cancelButtonColor: "#DD6B55",
				            allowOutsideClick: false,
							allowEscapeKey: false
						}).then((result) => {
							if (result.isConfirmed) {
								var url = base_url + "settings/visitors";
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