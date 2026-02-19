$(document).ready(function() {
    $("#form").validate({
        rules: {
            start_date:     { required: true },
            finish_date:    { required: true },
            start_time:     { required: true },
            finish_time:    { required: true }
        },
        errorElement: "em",
        errorPlacement: function(error, element) {
            error.addClass("help-block");
            error.insertAfter(element);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).parents(".col-sm-4").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents(".col-sm-4").addClass("has-success").removeClass("has-error");
        },
        submitHandler: function(form) {
            return true;
        }
    });

    $("#btnSubmit").click(function() {
        if ($("#form").valid() == true) {
            $('#btnSubmit').attr('disabled', '-1');
            $("#div_error").css("display", "none");
            $("#div_load").css("display", "inline");
            $.ajax({
                type: "POST",
                url: base_url + "entrances/save_access",
                data: $("#form").serialize(),
                dataType: "json",
                contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                cache: false,
                success: function(data) {
                    if (data.result == "error") {
                        $("#div_load").css("display", "none");
                        $("#div_error").css("display", "inline");
                        $("#span_msj").html(data.mensaje);
                        $('#btnSubmit').removeAttr('disabled');
                        return false;
                    }
                    if (data.result) {
                        $("#div_load").css("display", "none");
                        $('#btnSubmit').removeAttr('disabled');
                        var url = base_url + "entrances/show_qrcode/" + data.permiso + "/" + data.tipo;
                        $(location).attr("href", url);
                    } else {
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

$(function() {
    $("#start_date").datepicker({
        minDate: 'today',
        dateFormat: 'yy-mm-dd',
        onSelect: function(selectedDate) {
            var today = $.datepicker.formatDate('yy-mm-dd', new Date());
            if (selectedDate === today) {
                var now = new Date();
                var currentMinutesRaw = now.getMinutes();
                var roundedMinutes = Math.ceil(currentMinutesRaw / 5) * 5;
                var adjustedHours = now.getHours();
                var adjustedMinutes = roundedMinutes;
                if (roundedMinutes === 60) {
                    adjustedHours += 1;
                    adjustedMinutes = 0;
                }
                var currentMinutes = adjustedHours * 60 + adjustedMinutes;
                if ($("#hddTipo").val() != 1 && currentMinutes > 1080) {
                    Swal.fire({
                        title: "Visitantes",
                        text: "La hora actual supera las 6:00 PM. Se Seleccionará automáticamente la fecha de mañana.",
                        icon: "warning",
                        confirmButtonText: "Confirmar",
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                    var tomorrow = new Date();
                    tomorrow.setDate(tomorrow.getDate() + 1);
                    var tomorrowStr = $.datepicker.formatDate('yy-mm-dd', tomorrow);
                    $("#start_date").val(tomorrowStr);
                    $("#finish_date").val(tomorrowStr);
                    $("#finish_date").datepicker("option", "minDate", tomorrowStr);
                    $("#start_time_slider").slider("option", "min", 480);
                    $("#finish_time_slider").slider("option", "min", 485);
                    return;
                }
                $("#finish_date").val(selectedDate);
                $("#finish_date").datepicker("option", "minDate", selectedDate);
                var startMin = Math.max(480, currentMinutes);
                $("#start_time_slider").slider("option", "min", startMin);
                var currentValue = $("#start_time_slider").slider("value");
                if (currentValue < startMin) {
                    $("#start_time_slider").slider("value", startMin);
                    $("#start_time").val(formatTime(startMin));
                }
                var finishMin = Math.max(485, currentMinutes + 5);
                $("#finish_time_slider").slider("option", "min", finishMin);
                var finishValue = $("#finish_time_slider").slider("value");
                if (finishValue < finishMin) {
                    $("#finish_time_slider").slider("value", finishMin);
                    $("#finish_time").val(formatTime(finishMin));
                }
            } else {
                $("#finish_date").val(selectedDate);
                $("#finish_date").datepicker("option", "minDate", selectedDate);
                $("#start_time_slider").slider("option", "min", 480);
                $("#finish_time_slider").slider("option", "min", 485);
            }
        }
    });
    $("#finish_date").datepicker({
        minDate: 'today',
        dateFormat: 'yy-mm-dd'
    });
});

$(function() {
    function formatTime(minutes) {
        var hours = Math.floor(minutes / 60);
        var mins = minutes % 60;
        return (hours < 10 ? '0' : '') + hours + ':' + (mins < 10 ? '0' : '') + mins;
    }
    $("#start_time_slider").slider({
        min: 480,
        max: 1075,
        step: 5,
        value: 480,
        slide: function(event, ui) {
            $("#start_time").val(formatTime(ui.value));
            var newFinishValue = Math.min(1080, ui.value + 5);
            $("#finish_time_slider").slider("value", newFinishValue);
            $("#finish_time").val(formatTime(newFinishValue));
            $("#finish_time_slider").slider("option", "min", newFinishValue);
        },
        create: function(event, ui) {
            $("#start_time").val(formatTime(480));
        }
    });
    $("#finish_time_slider").slider({
        min: 485,
        max: 1080,
        step: 5,
        value: 485,
        slide: function(event, ui) {
            $("#finish_time").val(formatTime(ui.value));
        },
        create: function(event, ui) {
            $("#finish_time").val(formatTime(485));
        }
    });
    $("#start_time, #finish_time").prop('readonly', true);
});