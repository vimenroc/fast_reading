<?= $this->extend('layouts/main') ?>

<?= $this->section('container') ?>
<div class="row">
    <div class="col-12 mt-5 text-center">
    <h1>Lectura Rápida</h1><i class="fa fa-book fa-5x"></i> 
    </div>
</div>
<div class="row text-center mt-5">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-2 mb-2">
        <a href="<?php echo base_url('libros/'); ?>" class="text-decoration-none text-dark menu"><i class="fa fa-book"></i> Libros</a>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-2 mb-2">
        <a href="" class="text-decoration-none text-dark menu"><i class="fa fa-user"></i> Autores</a>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-2 mb-2">
        <a href="" class="text-decoration-none text-dark menu"><i class="fa fa-info"></i> Información</a>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-2 mb-2">
        <a href="" class="text-decoration-none text-dark menu"><i class="fa fa-search"></i> Buscar</a>
    </div>
    <?php
    if ($botones) {
        // print_r($botones);
        foreach ($botones as $botón) {
            echo "<div class=\"col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-2 mb-2\">";
            echo "<a href=\"$botón[href]\" class=\"text-decoration-none text-dark menu\"><i class=\"fa fa-$botón[ícono]\"></i> $botón[nombre]</a>";
            echo "</div>";
        }
    }
    ?>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?= $this->endSection() ?>
