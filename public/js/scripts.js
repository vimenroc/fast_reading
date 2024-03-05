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

function GetData(url, data, opciones = null){
    return $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: data,
        beforeSend: function() {},
        success: function(response) {
            console.log(response);
            if (opciones != null) {
                if(opciones.alerta){
                    DibujarAlerta(response);
                }
            }
            
        },
        error: function(error) {}
    });
}

function Guardar(url, formData, button = null){
    var alerta = $("#alerta");
    var botónTexto = "";
    // formData = JSON.parse(formData);
    console.log(formData);
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
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

function ComponenteLibro(libroURL, libroTítulo, libroReseña, portadaURL){

    let libro =
    `<div class="mb-3 mt-3 p-3 col-12 col-md-6">
        <a class="text-decoration-none" href="${libroURL}">
            <div class="card bg-dark text-white">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="${portadaURL}" class="img-fluid rounded-start" alt="..." style=" max-height: 200px">
                    </div>
                    <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">${libroTítulo}</h5>
                        <p class="card-text">${libroReseña.substring(0, 100)}...</p>
                    </div>
                    </div>
                </div>
            </div>
        </a>
    </div>`;

    return libro;
}

function DibujarAlerta(respuesta){
    switch (respuesta.alert) {
        case "success":
            icon = "check";
            break;
        case "warning":
            icon = "exclamation-triangle";
            break;
        case "danger":
            icon = "exclamation-triangle";
            break;
        case "info":
            icon = "flag";
            break;
        case "primary":
            icon = "check";
            break;
    
        default:
            icon = "check";
            break;
    }
    let contenedorAlertas = $("#contenedor-alertas");
    let alerta = `<div class="alert alert-${respuesta.alert} alert-dismissible d-flex">
            <div class="pe-2" style=""><i class="fa fa-${icon} fa-bounce" aria-hidden="true"></i></div>
            <div class="">${respuesta.msg}</div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
    contenedorAlertas.append(alerta);
}