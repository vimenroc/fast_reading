<?php function Contenido($data){ ?>
    <div class="row">
        <div  class="col-12 text-center mb-5 mt-5">
            <h2 id="título">
                <i class="fa fa-spinner fa-pulse fa-fw"></i> Cargando...
            </h2>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12"></div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-1 h5">
            Reseña
            
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12"></div>
        <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12"></div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-2 mb-5" id="reseña">
            <i class="fa fa-spinner fa-pulse fa-fw"></i> Cargando...
            
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12"></div>
            
        
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6 p-0">
            <a class="btn btn-dark w-100" href="<?= base_url("/libro/$data[IDlibro]/cap/nuevo");?>">Nuevo</a>
        </div>
        <div class="col-3"></div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6 p-0">
            <ul id="caps" class="list-group list-group-flush mt-5">
                <li class="list-group-item"><i class="fa fa-spinner fa-pulse fa-fw"></i> Cargando...</li>
            </ul>
        </div>
        <div class="col-3"></div>
    </div>
<?php }?>

<?php function Scripts($data){ ?>
    <script>    
        let libro = <?= $data['IDlibro'] ?>;
        
        // A $( document ).ready() block.
        $( document ).ready(function() {
            console.log();
            LibroData();
            LibroCapítulos();
        });
        
        function LibroData(){
            $.ajax({
                url: `<?= base_url("b/libro");?>`,
                method : "POST",
                data: {IDlibro : libro},
                dataType: "json",
                beforeSend: function() {
                },
                success: function(data) {
                    if (data) {
                        var edit = $("<a>").attr("href", `<?= base_url("libro/detalles/");?>${libro}`).html(" <i class='fas fa-edit'></i>").addClass("text-dark text-decoration-none");
                        
                        $("#título").html(data.título).append(edit);
                        
                        $("#reseña").html(data.reseña);
                        
                    }
                },
                error: function(error) {}
            });
        };
        
        function LibroCapítulos(){
            $.ajax({
                url: `<?= base_url("b/libro/caps");?>`,
                method : "POST",
                data: {IDlibro : libro},
                dataType: "json",
                beforeSend: function() {
                    
                },
                success: function(data) {
                    if (data) {
                        $("#caps").html(`<li class="list-group-item border-0 mb-3">Capítulos</li>`);
                        console.log(data);
                        data.forEach(element => {
                            var detailsLink = `<a class="text-black" href="<?= base_url('libro/cap/');?>${element.capítuloID}/detalles"><i class="fa fa-info-circle"></i></a>`;
                            $("#caps").append(`<li class="list-group-item border-0">${detailsLink} <a href="<?= base_url('libro/cap/');?>${element.capítuloID}" class="text-dark"><b></b> <i class="fas fa-book-open"></i> Capítulo ${element.capítuloID} - ${element.título}</a></li>`);
                        });
                        // $("#título").html("");
                        // $("#título").html(data.título);
                        // $("#título").html("");
                        // $("#reseña").html(data.reseña);
                        
                    }
                },
                error: function(error) {}
            });
        };
        
    </script>
<?php }?>