
<?php function Contenido($data){ ?>
<div class="row">
    <div  class="col-12 text-center mb-5 mt-5">
        <h2 id="cap">
            <?= $data['title']; ?>
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
<?php }?>

<?php function Scripts($data){?>
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
        $.ajax({
            url: "<?= base_url('b/libros'); ?>",
            type: "POST",
            data:{'idioma':idioma},
            dataType: "json",
            beforeSend: function() {
                $("#cat-libros").html('Cargando...');
            },
            success: function(data) {
                console.log(data);
                $("#cat-libros").html('');
                if (data) {
                    data.forEach(element => {
                        // con3 = `<button class="btn btn-outline-dark border-0 w-100 h-100"><i class="fa fa-book align-self-start"></i> ${element.título}</button>`;
                        con2 = `<a href="<?= base_url('libro/'); ?>${element.libroID}" class="text-decoration-none text-dark cat-libro"><i class="fa fa-book align-self-start"></i> ${element.título}</a>`;
                        con1 = `<div class="col-lg-4 col-md-6 col-sm-6 col-12 mt-2 p-2">${con2}</div>`;
                        $("#cat-libros").append(`${con1}`);
                    });
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
<?php }?>