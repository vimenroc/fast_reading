<?= $this->extend('layouts/main') ?>

<?= $this->section('container') ?>
<div class="row">
    <div  class="col-12 text-center mb-5 mt-5">
        <h2 id="cap">
            <?= $title; ?>
        </h2>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="input-group input-group-s mb-3">
            <label class="input-group-text" for="idioma">Options</label>
            <select class="form-select form-select-sm" id="idioma">
                <option selected>Cargando...</option>
            </select>
        </div>
    </div>
    
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <button id="mostrar" type="button" class="btn btn-dark w-100 "><i class="fa fa-search"></i> Mostrar</button>
    </div>
    
</div>
<div class="row mt-5 p-3" id="cat-libros">

</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function(){
        
        CargarIdiomas();
        
        
        $("#mostrar").click(function(e){
            e.preventDefault();
            CargarLibros();
        });
    }
    );
    
    function CargarLibros(){
        let idioma = $("#idioma").val();
        let cargarLibrosURL = "<?= base_url('b/libros'); ?>";
        let cargarLibrosData = {'idioma':idioma};


        GetData(cargarLibrosURL, cargarLibrosData).then(respuesta => {
            $("#cat-libros").html('');
            if (respuesta) {
                respuesta.data.forEach(element => {
                    let libro = ComponenteLibro('<?= base_url("libro/")?>'+element.libroID, element.libroTítulo, element.libroReseña, element.libroPortada);
                    $("#cat-libros").append(libro);
                });
            }
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
                if (data) {
                    $("#idioma").html(`<option value=0>Todos los idiomas</option>`);
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
<?= $this->endSection() ?>