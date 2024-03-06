<?= $this->extend('layouts/main') ?>

<?= $this->section('container') ?>
    <div class="row">
        <div  class="col-12 text-center mb-5 mt-5">
            <h2 id="título">
                <i class="fa fa-spinner fa-pulse fa-fw"></i> Cargando...
            </h2>
        </div>
        
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-12 m-auto">
            <div class="row">
                <div class="col-lg-2 col-12 text-center mb-3" id="portada">
                    <i class="fa fa-spinner fa-pulse fa-fw"></i> Cargando...
                </div>
                <div class="col-lg-10 col-12 mb-3" id="reseña">
                    <i class="fa fa-spinner fa-pulse fa-fw"></i> Cargando...
                </div>
            </div>
        </div>

        
    </div>

    <?php 
    if (isset($usuarioID)) { ?>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-12 m-auto">
            <div class="row">
                <div class="col-lg-2 col-12 text-center mb-3">
                    
                </div>
                <div class="col-lg-10 col-12 mb-3">
                    <button id="favorito" class="btn btn-dark w-25"><i class="fa-regular fa-star"></i></button>
                </div>
            </div>
        </div>
    </div>
    

    <div class="row">
        <div class="col-3"></div>
        <div class="col-6 p-0">
            <a class="btn btn-dark w-100" href="<?= base_url("/libro/$libroID/cap/nuevo");?>">Nuevo</a>
        </div>
        <div class="col-3"></div>
    </div>
    <?php } ?>
    
    <div class="row">
        <div class="col-lg-3 col-md-2 col-sm-12 col-1"></div>
        <div class="col-lg-6 col-md-8 col-sm-12 col-10 ">
            <ul id="caps" class="list-group list-group-flush mt-5">
                <li class="list-group-item"><i class="fa fa-spinner fa-pulse fa-fw"></i> Cargando...</li>
            </ul>
        </div>
        <div class="col-lg-3 col-md-2 col-sm-12 col-1"></div>
    </div>
    
    <?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script src="<?= base_url("public/js/scripts.js");?>"></script>
    <script>    
        let libro = <?= $libroID ?>;
        let favoritosURL = "";
        let favoritosData = {
            libroID : <?= $libroID ?>,
            <?php if (isset($usuarioID)) {
                echo "usuarioID : $usuarioID";
            } ?>
        };

        // A $( document ).ready() block.
        $( document ).ready(function() {
            console.log();
            LibroData("<?= base_url('b/libro');?>",{IDlibro : libro}).then(response => {
                if (response.data) {
                    <?php if (isset($usuarioID)) { ?>
                    var edit = $("<a>").attr("href", `<?= base_url("libro/");?>${libro}/detalles`).html(" <i class='fas fa-edit'></i>").addClass("text-dark text-decoration-none");
                    <?php }else{ ?>
                    var edit = "";
                    <?php } ?>
                    $("#título").html(response.data.libroTítulo).append(edit);
                     
                    response.data.libroReseña = response.data.libroReseña.replace(/\n/g, "<br>");    
                    $("#reseña").html(response.data.libroReseña);
                    let portada = $("<img>").attr("src", response.data.libroPortada).addClass("img-fluid").css("max-height", "300px");
                    $("#portada").html(portada);
                }
            });
            LibroCapítulos();

            <?php
            // Funciones de js que solo deben ser llamadas si hay una sesión iniciada.
            if (isset($usuarioID)) {
                echo "RevisarFavoritos();";
                echo "ModificarFavorito();";
            } ?>
            
        });
        
        function RevisarFavoritos(){
            let revisarFavoritosURL = `<?= base_url("b/libros/favoritos/revisar");?>`;
            GetData(revisarFavoritosURL, favoritosData, {alerta: false}).then(response => {
                if (response.data) {
                    favoritosURL = `<?= base_url("b/libros/favoritos/eliminar")?>`;
                    $("#favorito").html(`<i class="fa-solid fa-star"></i> ${response.msg}`);
                }else{
                    favoritosURL = `<?= base_url("b/libros/favoritos/agregar")?>`;
                    $("#favorito").html(`<i class="fa-regular fa-star"></i> ${response.msg}`);
                }
            });
        };
        
        function ModificarFavorito(){
            $("#favorito").on('click', function (e){
                e.preventDefault();
                console.log("favs");
                GetData(favoritosURL, favoritosData, {alerta: false}).then(response => {
                    RevisarFavoritos();
                });
            });
        }

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
                            <?php if (isset($usuarioID)) { ?>
                            var detailsLink = `<a class="text-black" href="<?= base_url('libro/');?>${libro}/cap/${element.capítuloID}/detalles"><i class="fa fa-edit"></i></a>`;
                            <?php }else{ ?>
                            var detailsLink = "";
                            <?php } ?>
                            $("#caps").append(`<li class="list-group-item border-0">${detailsLink} <a href="<?= base_url('libro/cap/');?>${element.capítuloID}" class="text-dark"><b></b> <i class="fas fa-book-open"></i> Capítulo ${element.capítuloNo} - ${element.título}</a></li>`);
                        });
                    }
                },
                error: function(error) {}
            });
        };
        
    </script>
    <?= $this->endSection() ?>