<?php function Contenido($data){ ?>
<div class="row">
    <div  class="col-12 text-center mb-5 mt-5">
        <h2 id="cap">
            Capítulo
        </h2>
    </div>
    <div id="texto" class="col-12 text-center" style="font-size: 3rem; min-height: 12vh;">
    </div>
    <div class="col-12 text-center">
        <button class="btn btn-primary btn-dark" id= "resume" ><i id="btn-icon" class="fa fa-play"></i></button>
        <button class="btn btn-primary btn-dark" id= "stop" ><i id="btn-icon" class="fa fa-stop"></i></button>
    </div>
    <div class="col-12 mt-3">
        <div class="row">
            <div class="col-lg-5 col-md-4 col-sm-3 col-4 form-text p-0 text-end"><label for="" id="palabras-segundo" class="col-form-label">(4 palabras/seg)</label></div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-4 ">
                <input type="number" class="form-control form-control-sm" placeholder="250" min="1" value="250" id="speed">
            </div>
            <div class="col-lg-5 col-md-4 col-sm-3 col-4 form-text p-0 text-start"><label for="" class="col-form-label">milisegundos</label></div>
        </div>
    </div>
    <div class="col-12">
        <label for="progreso" class="form-label" id="progreso-label">Progreso</label>
        <input type="range" class="form-range" id="progreso" value=0 min=1    >
    </div>
</div>
<?php }?>

<?php function Scripts($data){ ?>
    <script src="<?= base_url("public/js/scripts.js");?>"></script>
    <script>    
        let texto = "Texto de ejemplo";
        let arr1 = [];
        
        let running = false;
        let start = 0;
        let speed = 250;
        
        // A $( document ).ready() block.
        $( document ).ready(function() {
            
            var capítuloDaraUTL = "<?=base_url('b/libro/cap/detalles')?>";
            var capítuloDataArgs = {capítulo: <?= $data['IDcapítulo']?>, f:1};
            
            GetData(capítuloDaraUTL, capítuloDataArgs).then(function(data){
                
                    arr1 = data.body.split(' ');
                    
                    var botónRegresar = $("<a></a>").addClass("btn btn-dark").html("<i class='fas fa-arrow-left'></i> Regresar").attr("href", "<?= base_url('libro/')?>"+data.libro);
                    ControlesFinal([botónRegresar]);
                    
                    $('#progreso').attr('max', arr1.length);
                    $("#cap").html(`<i class="fa fa-book"></i> ${data.título}`);
                    $("#resume").prop( "disabled", false )
            });
            
            $("#progreso").change(function(){
                start = $(this).val();
            });
            
            $("#stop").click(function(e){
                e.preventDefault();
                running = false;
                $("#btn-icon").removeClass("fa-pause");
                $("#btn-icon").addClass("fa-play");
                start = 0;
                $("#texto").html("");
                $("#progreso").val(0);
                
            });
            
            $("#resume").click(function(e){
                e.preventDefault();
                speed = $("#speed").val();
                if (running == true) {
                    $("#btn-icon").removeClass("fa-pause");
                    $("#btn-icon").addClass("fa-play");
                    running = false;
                }else{
                    running = true;
                    $("#btn-icon").removeClass("fa-play");
                    $("#btn-icon").addClass("fa-pause");
                    demo(speed);
                }
            });
            
        }).on('input', '#progreso', function() {
            // $('#slider_value').html( $(this).val() );
            $("#btn-icon").removeClass("fa-pause");
            $("#btn-icon").addClass("fa-play");
            running = false;
            var index = $(this).val();
            $("#texto").html(arr1[index-1]);
            
            start = $(this).val();
        });
        
        $("#speed").change(function(){
            var WpS = 1000/$(this).val();
            WpS = WpS.toFixed(1);
            $("#palabras-segundo").text(`(${WpS} palabras/seg)`);
        });
        
        function PrepareReading(bodyString){
            var bodyArray;
            bodyArray = bodyString.split(' ');
            return bodyArray;
        };

        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }

        async function demo(speed) {
            for (let i = start; i < arr1.length && running; i++) {
                $("#texto").html(arr1[i]);
                start = i;
                $('#progreso[type=range]').val(i+1);
                await sleep(speed);
            }
        }
        
    </script>
<?php }?>