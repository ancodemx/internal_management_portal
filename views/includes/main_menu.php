<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="Home" style="font-size: 16px;">HOTELES PALACE</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto" style="font-size: 13px;">
            <?php

            foreach ($_SESSION["menu_perfil"] as $valor1)
            {


            ?>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $valor1['text']; ?></a>
                <div class="dropdown-menu" style="font-size: 12px;">
                    <?php
                    foreach ($valor1[opcion] as $valor2)
                    {
                    ?>
                    <a class="dropdown-item" href="<?php echo $valor2[metodo_opcion]; ?>"><?php echo $valor2[nombre_opcion]; ?></a>
                    <?php
                    }
                    ?>
                </div>
            </li>

            <?php
            }
            ?>
            <!--
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell"></i> 
                    <span class="badge badge-danger">0</span>
                </a>
                <div class="dropdown-menu" style="font-size: 12px;">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
                
            </li>
            -->

        </ul>

        <div style="color: #ccc; padding: 0px 15px 0px 15px;"><?php echo $_SESSION["nombreSucursal"]; ?></div>
        <button class="btn btn-success my-2 my-sm-0" onclick="cerrar_sesion();">Usuario: <?php echo $_SESSION["login_usuario"] ?></button>

    </div>
    
</nav>

