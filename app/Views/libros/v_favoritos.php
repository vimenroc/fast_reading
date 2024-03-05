<?= $this->extend('layouts/main') ?>

<?= $this->section('container') ?>
<div class="row">
    <div class="col-12 mt-5 text-center">
    <h1>Favoritos</h1><i class="fa fa-book fa-5x"></i> 
    </div>
</div>

<div id="lista-favoritos" class="row mt-5">
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $( document ).ready(function() {
        ObtenerFavoritos();
    });

    function ObtenerFavoritos(){
        let url = "<?= base_url('b/libros/favoritos')?>";
        let loginData = {
            usuarioID: <?= $usuarioID ?>,
            pw: $('#pw').val()
        }   
        GetData(url, loginData).then(response => {
            console.log(response);
            if (response.status && response.data) {
                let contenedorFavoritos = $('#lista-favoritos');

                response.data.forEach(element => {
                    let libro = ComponenteLibro('<?= base_url("libro/")?>'+element.libroID, element.libroTítulo, element.libroReseña, element.libroPortada);
                    contenedorFavoritos.append(libro);
                });
            }
        });
    }
</script>



<?= $this->endSection() ?>
