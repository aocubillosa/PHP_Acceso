$(document).ready( function() {

	$("#nombre").bloquearNumeros().maxlength(50);
	$("#telefono").bloquearTexto().maxlength(10);
	$("#nit").bloquearTexto().maxlength(10);
	
	$( "#form" ).validate( {
		rules: {
			nit: 			{ required: true },
			nombre: 		{ required: true, minlength: 3, maxlength:50 },
			telefono: 		{ required: true },
			direccion: 		{ required: true }
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
				url: base_url + "settings/save_school",
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
						var url = base_url + "settings/schools/" + data.state;
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

	$('#btnSubir').click(function(event) {
        event.preventDefault();
        $('#btnSubir').addClass('disabled');
        $('#animationload').fadeIn();
        $('#formCargue').submit();
    });
});

$(function(){ 
	$(".btn-success").click(function () {
		var oID = $(this).attr("id");
        $.ajax ({
            type: 'POST',
			url: base_url + '/settings/cargarModalSchools',
            data: {'idSchool': oID},
            cache: false,
            success: function (data) {
                $('#tablaDatos').html(data);
            }
        });
	});	
});