
<?php function Contenido($data){ ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<div class="row">
    <div  class="col-12 text-center mb-5 mt-5">
        <h2 id="cap">
            <?= $data['title']; ?>
        </h2>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <form id="nuevo-libro" action="">
            <div class="mb-3">
                <label class="form-label" for="título">Título</label>
                <input type="text" name="título" class="form-control form-control-sm" id="título" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label" for="idioma">Idioma</label>
                <select class="form-select form-select-sm" id="idioma" name="idioma" required>
                    <option selected>Cargando...</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label" for="título">Reseña</label>
                <textarea type="text" name="reseña" class="form-control form-control-sm" id="reseña"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label" for="single-select-field">¿Relacionado a otro libro?</label>
                <select class="form-select form-select-sm" id="single-select-field" name="relacionado">
                </select>
            </div>
            
            <div>
            <button id="guardar" type="submit" class="btn btn-dark w-100 mt-5"><i class="fa fa-save"></i> Guardar</button>
            </div>
        </form>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    </div>
</div>

<div class="row">
    <div class="col-3"></div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-5">
        <div id="alerta" class="alert" role="alert" style="display:none">
        </div>
    </div>
    <div class="col-3"></div>
</div>

<?php }?>

<?php function Scripts($data){?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
<script>
    var alerta = $("#alerta");
    $(document).ready(function(){
        
        CargarIdiomas();
        
        
        $("#nuevo-libro").submit(function(e){
            e.preventDefault();
            // Get form
            var form = $('#nuevo-libro')[0];

            // FormData object 
            var formData = new FormData(form);
            console.log(formData);
            Guardar(formData);
        });
        
        $( '#single-select-field' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
        } );
    }
    );
    
    function Guardar(formData){
        
        $.ajax({
            url: "<?= base_url('b/libros/nuevo'); ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            // processData: false,
            dataType: "json",
            beforeSend: function() {
                $("#guardar").prop("disabled", true);
            },
            success: function(data) {
                console.log(data);
                if (data.status) {
                    alerta.addClass("alert-success");
                    alerta.text(data.msg);
                    alerta.show();
                    setTimeout(function(){
                        window.location.href = "<?= base_url('libros'); ?>";
                    }, 3000);
                }else{
                    
                }
            },
            error: function(error) {}
        });
    }
    
    
    function CargarIdiomas(){
        $.ajax({
            url: "<?= base_url('b/idiomas'); ?>",
            type: "POST",
            dataType: "json",
            beforeSend: function() {
            },
            success: function(data) {
                console.log(data);
                if (data) {
                    $("#idioma").html(``);
                    data.forEach(element => {
                        $("#idioma").append(`<option value=${element.id}>${element.ícono} ${element.idioma}</option>`);
                    });
                }else{
                    $("#idioma").html();
                    $("#idioma").prop( "disabled", true );
                    $("#alerta").text("No se encontraron idiomas");
                    $("#alerta").show();
                }
            },
            error: function(error) {}
        });
    }
</script>
<?php }?>