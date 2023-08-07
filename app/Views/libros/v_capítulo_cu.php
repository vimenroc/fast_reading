<?php function Contenido($data){ ?>

    <div class="row">
    <div class="col-lg-3 col-md-3 col-sm-12 col-12">
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <form id="capítulo-detalles" action="">
            <div class="form-group mt-3">
                <label for="título">Titulo</label>
                <input type="text" class="form-control form-control-sm" id="título" name = "título">
            </div>
            <div class="form-group mt-3">
                <label for="título">No. de capítulo</label>
                <input class="form-control form-control-sm" id="no-capítulo" name="no-capítulo">
            </div>
            <div class="form-group mt-3">
                <label for="cuerpo" class="form-label">Contenido</label>
                <textarea name="cuerpo" id="cuerpo" class="form-control fs-6" style="font-size: .8rem !important;" rows="10"></textarea>
            </div>
            
            <button id="guardar" type="submit" class="btn btn-dark w-100 mt-5"><i class="fa fa-save"></i> Guardar</button>
        </form>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-12 col-12">
    </div>    
</div>
<?php }?>

<?php function Scripts($data){ ?>
    <script src="<?= base_url("public/js/scripts.js");?>"></script>
    <script>
        // A $( document ).ready() block.
        <?php if ($data['capítulo']){ ?>
            let libro = <?= $data['libro'] ?>;
            let capítulo = <?= $data['capítulo'] ?>;
            let método = "U";
            let backURL = "<?= base_url('libro/')?>"+libro;
        <?php }else{
            echo "let libro =  $data[libro]; let capítulo = null; let método = 'C'; let backURL = '".base_url('libros')."'";
        } ?>
        
        $( document ).ready(function() {
            console.log();
            var capítuloData = {
                    capítulo: capítulo
                };
            var capítuloURL = "<?php echo base_url('b/libro/cap/detalles');?>";
            
            if (capítulo) {
                GetData(capítuloURL, capítuloData).then(data => {
                    $('#título').val(data.título);
                    $('#no-capítulo').val(data.capítuloNo);
                    $('#cuerpo').val(data.body);
                    
                });
            }
            
            var url = "<?= base_url('b/libro/caps/cu'); ?>";
            $('#capítulo-detalles').submit(function(e){
                e.preventDefault();
                var formData = new FormData(this);
                console.log(formData);
                formData.append('capítulo', capítulo);
                formData.append('libro', libro);
                formData.append('método', método);
                Guardar(url ,formData, $("#guardar"));
            });
            
            var botónRegresar = $("<a></a>").addClass("btn btn-dark").html("<i class='fas fa-arrow-left'></i> Regresar").attr("href", "<?= base_url('libro/')?>"+libro);
            ControlesFinal([botónRegresar]);
        });
        

        
    </script>
<?php }?>