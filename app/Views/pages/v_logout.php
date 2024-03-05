<?= $this->extend('layouts/main') ?>

<?= $this->section('container') ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script src="<?= base_url("public/js/scripts.js");?>"></script>
    <script>
        $( document ).ready(function() {

         
                let url = "<?= base_url('b/logout')?>";
                let loginData = {}
                GetData(url, loginData).then(response => {
                    window.location.href = "<?= base_url('/')?>";
                });
            
        });
    </script>
<?= $this->endSection() ?>