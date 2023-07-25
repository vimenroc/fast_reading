<?php function Contenido($data){ ?>
    <form action="" id="detalles">
        <div class="row">
            <div  class="col-12 text-center mb-5 mt-5">
                <h2>
                    Información del capítulo
                </h2>
                
            </div>
            
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12"></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-5 mb-5">
                <label for="título" class="form-label">Título</label>
                <input type="text" class="form-control" id="título" name="título">
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12"></div>
                
            
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12"></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-5">
                <label for="cuerpo" class="form-label">Contenido</label>
                <textarea name="cuerpo" id="cuerpo" class="form-control fs-6" style="font-size: .8rem !important;" rows="10"></textarea>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12"></div>
        </div>
        <div class="row">
            <input type="number" id="título-f" name="título-f" class="d-none" value = 1>
            <input type="number" id="cuerpo-f" name="cuerpo-f" class="d-none" value = 1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12"></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-5">
                <button class="btn btn-dark w-100" type="submit"><i class="fas fa-save"></i> Guardar</button>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12"></div>
        </div>
        
    </form>
<?php }?>

<?php function Scripts($data){ ?>
    <script src="<?= base_url("public/js/scripts.js");?>"></script>
    <script>
        // A $( document ).ready() block.
        $( document ).ready(function() {
            console.log();
            CapítuloData();
            
            $('#detalles').submit(function(e){
                e.preventDefault();
                var formData = new FormData(this);
                console.log(formData);
                formData.append('capítulo', <?= $data['IDcapítulo']?>);
                CambiarData(formData);
            });
            
            CheckFlag("cuerpo");
            CheckFlag("título");
        });
        
        function CheckFlag(id){
            $(`#${id}`).on("change", function(){
                $(`#${id}-f`).val(1);
            })
        }
        
        function CambiarData(formData){
            
            $.ajax({
                url: "<?php echo base_url('b/libro/cap/detalles/u');?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function() {
                    if (formData.get('cuerpo-f')==0) {
                        console.log(formData.get('cuerpo-f'));
                        formData.delete('cuerpo');
                    }
                    if (formData.get('título-f')==0) {
                        console.log(formData.get('cuerpo-f'));
                        formData.delete('título');
                    }
                },
                success: function(data) {
                    $("#alerta").addClass(data.alert).text(data.msg).show();
                    
                },
                error: function(error) {}
            });
        };
        
        
        
        function CapítuloData(){
            $.ajax({
                url: "<?php echo base_url('b/libro/cap/detalles');?>",
                type: "POST",
                dataType: "json",
                data: {
                    capítulo: <?= $data['IDcapítulo']?>, f: 1
                },
                beforeSend: function() {
                    console.log("Data");
                },
                success: function(data) {
                    
                    $('#título').val(data.título);
                    $('#cuerpo').val(data.body);
                    var botónRegresar = $("<a></a>").addClass("btn btn-dark").html("<i class='fas fa-arrow-left'></i> Regresar").attr("href", "<?= base_url('libro/')?>"+data.libro);
                    ControlesFinal([botónRegresar]);
                    
                },
                error: function(error) {}
            });
        }
        
    </script>
<?php }?>