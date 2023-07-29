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
        error: function(error) {}
    });
    
}

function ControlesFinal(elementos){
    var controlesContenedor = $("#controles-final");
    if (elementos) {
        elementos.forEach(element => {
            console.log(element);
            controlesContenedor.append(element);
        });
    }
}
