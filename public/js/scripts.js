function LibroData(url, data){
    return $.ajax({
        url: url,
        method : "POST",
        data: data,
        dataType: "json",
        beforeSend: function() {},
        success: function(data) {},
        error: function(error) {}
    });
};

function GetData(url, data){
    return $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: data,
        beforeSend: function() {},
        success: function(data) {},
        error: function(error) {}
    });
}

function Guardar(url, formData, button = null){
    var alerta = $("#alerta");
    var botónTexto = "";
    console.log(formData);
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        beforeSend: function() {
            if (button != null) {
                button.prop("disabled", true);
                botónTexto = button.text();
                button.html(`<i class="fa fa-spinner fa-pulse"></i>`);
            } 
        },
        success: function(data) {
            console.log(data);
            if (data.status) {
                alerta.addClass("alert-success");
                alerta.text(data.msg);
                alerta.show();
                // setTimeout(function(){
                //     location.reload();
                // }, 3000);
            }else{
                alerta.addClass("alert-danger");
                alerta.text(data.msg);
                alerta.show();
            }
        },
        complete: function(error) {
            if (button != null) {
                button.prop("disabled", false);
                button.html(botónTexto);
            }
        },
        error: function(error) {}
    });
    
}

function ControlesFinal(elementos){
    var controlesContenedor = $("#controles-final");
    if (elementos) {
        elementos.forEach(element => {
            controlesContenedor.append(element);
        });
    }
}
