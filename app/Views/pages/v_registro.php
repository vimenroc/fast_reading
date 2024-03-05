<?= $this->extend('layouts/main') ?>

<?= $this->section('container') ?>

    <div class="row">
    <div class="col-lg-3 col-md-3 col-sm-12 col-12">
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <form id="capítulo-detalles" action="">
            <div class="form-group mt-3">
                <label for="usuario"><i class="fa fa-user"></i> Usuario</label>
                <input class="form-control form-control-sm" id="usuario" name="usuario">
            </div>
            <div class="form-group mt-3">
                <label for="pw"><i class="fa fa-lock"></i> Contraseña</label>
                <input type="password" class="form-control form-control-sm" id="pw" name = "pw">
            </div>
            
            <button id="registro" type="submit" class="btn btn-dark w-100 mt-5">Guardar</button>
        </form>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-12 col-12">
    </div>    
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script src="<?= base_url("public/js/scripts.js");?>"></script>
    <script>
        
        <?php
        // Si ya hay una sesión iniciada redirigir a la página principal.
        $session = session();
        if ($session->get('usuario')) {
            echo "window.location.href = '".base_url('/')."';";
        }
        ?>
        $( document ).ready(function() {

            $('#registro').click(function (e) {
                e.preventDefault();
                let url = "<?= base_url('b/registro')?>";
                let loginData = {
                    usuario: $('#usuario').val(),
                    pw: $('#pw').val(),
                }
                GetData(url, loginData).then(response => {
                    console.log(response);
                    if (response.status && response.data) {
                        
                        window.location.href = "<?= base_url('/')?>";

                    }
                });
            });
        });
        

        
    </script>
<?= $this->endSection() ?>