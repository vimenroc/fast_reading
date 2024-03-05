<?= $this->extend('layouts/main') ?>

<?= $this->section('container') ?>
<div class="row">
    <div  class="col-12 text-center mb-5 mt-5">
        <h2 id="cabecera">
            <i class="fa fa-spinner fa-pulse"></i> Cargando...
        </h2>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-12 col-12">
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <form id="libro-detalles" action="">
            <div class="form-group mt-3">
                <label for="título">Titulo</label>
                <input type="text" class="form-control form-control-sm" id="título" name = "título">
            </div>
            <div class="form-group mt-3">
                <label for="título">Reseña</label>
                <textarea type="text" class="form-control form-control-sm" id="reseña" name="reseña" rows="10"></textarea>
            </div>
            <div class="form-group mt-3">
                <label for="título">Idioma</label>
                <select class="form-select form-select-sm" id="idioma" name="idioma">
                </select>
            </div>
            <button id="guardar" type="submit" class="btn btn-dark w-100 mt-5"><i class="fa fa-save"></i> Guardar</button>
        </form>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-12 col-12">
    </div>    
</div>
<div class="row mt-5 p-3" id="cat-libros">

</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script src="<?= base_url("public/js/scripts.js");?>"></script>
    <script>
        <?php if ($libro){ ?>
            let libro = <?= $libro ?>;
            let método = "U";
            let backURL = "<?= base_url('libro/')?>"+libro;
        <?php }else{
            echo "let libro = null; let método = 'C'; let backURL = '".base_url('libros')."'";
        } ?>
        
        $(document).ready(function(){
            console.log(libro);
            var botónRegresar = $("<a></a>").addClass("btn btn-dark").html("<i class='fas fa-arrow-left'></i> Regresar").attr("href", backURL);
            ControlesFinal([botónRegresar]);
            
            
            CargarIdiomas();
            
            if (libro) {
                LibroData("<?= base_url('b/libro');?>",{IDlibro : libro}).then(data => {
                    if (data) {
                        $("title").text(`ℹ️: ${data.título}`);
                        $("#cabecera").text(`Detalles del libro: ${data.título}`);
                        $("#título").val(data.título);
                        $("#reseña").val(data.reseña);
                    }
                });
            }else{
                $("#cabecera").text(`Nuevo registro de libro`);
            }
            
            
                    
            var url = "<?= base_url('b/libros/cu'); ?>";
            $("#libro-detalles").submit(function(e){
                e.preventDefault();
                // Get form
                var form = $('#libro-detalles')[0];

                // FormData object 
                var formData = new FormData(form);
                formData.append("libro", libro);
                formData.append("método", método);
                
                Guardar(url, formData, $("#guardar"));
            });
        });
        
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
<?= $this->endSection() ?>