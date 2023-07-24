<?php function Contenido($data){ ?>
    <div class="row mt-5">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-1">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    Nuevo capítulo para: <h3 id="título"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></h3>
                </div>
                <form  id="nuevo-capítulo"action="">
                
                <div class="col-12">    
                    <label for="nuevo-título" class="form-label">Título</label>
                    <input type="text" class="form-control" id="nuevo-título" name = "nuevo-título" required>
                </div>
                    
                    
                <div class="col-12 mt-5 bt-1">
                    <button id="guardar" type="submit" class="btn btn-dark w-100"><i class="fa fa-save"></i> Guardar</button>
                </div>
                    
                    
                </form>
            </div>
            
        </div>
        <div class="col-lg-3"></div>
        
    </div>
<?php }?>

<?php function Scripts($data){ ?>
    <script src="<?= base_url("public/js/scripts.js");?>"></script>
    <script>
        let libro = <?= $data['IDlibro'];?>;
        let libroResult;
        let result;
            
        $(document).ready(function(){
            var libroDataUrl = "<?= base_url('b/libro');?>";
            var libroData = {IDlibro : libro};
            
            var res =  LibroData(libroDataUrl, libroData).then((data) => {
                console.log(data);
                $("#título").html(`${data.título}`);
            });
            
            
            var guardarURL = "<?= base_url('b/libro/caps/c');?>";
            
            $("#nuevo-capítulo").on("submit", function(e){
                e.preventDefault();
                
                var form = $('#nuevo-capítulo')[0];
                // FormData object 
                var formData = new FormData(form);
                formData.append("IDlibro", libro);
                Guardar(guardarURL, formData);
            });
            
        });
        
        

    </script>
<?php }?>