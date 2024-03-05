<ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
    <?php
    echo $botónUsuario;
    ?>
    
    

    <li class="nav-item">
        <a class="nav-link" aria-current="page" href="<?= base_url(); ?>"><i class="fa fa-home"></i> Inicio</a>
    </li>

    <?php

    if ($usuario) {?>
    
    <li class="nav-item">
        <a class="nav-link" aria-current="page" href="<?= base_url('usuario/'.$usuario->username.'/favoritos'); ?>"><i class="fa fa-star"></i> Favoritos</a>
    </li>

    <?php
    }
    ?>
    
    <hr>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-book"></i> Libros
        </a>
        <ul class="dropdown-menu dropdown-menu-dark">
            <li><a class="dropdown-item" href="<?php echo base_url('libros/nuevo'); ?>"><i class="fa fa-plus"></i> Nuevo</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="<?php echo base_url('libros/lista'); ?>"><i class="fa fa-list"></i> Listado</a></li>
        </ul>
    </li>
</ul>
<form class="d-flex mt-3" role="search">
    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
    <button class="btn btn-success" type="submit">Search</button>
</form>