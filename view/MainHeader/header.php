<header class="site-header">
    <div class="container-fluid">

        <a href="#" class="site-logo">
            <img class="hidden-md-down" src="../../public/img/TA PJECHIS.ico" alt="">
            <img class="hidden-lg-up" src="../../public/img/TA PJECHIS.ico" alt="">
        </a>

        <button id="show-hide-sidebar-toggle" class="show-hide-sidebar">
            <span>toggle menu</span>
        </button>

        <button class="hamburger hamburger--htla">
            <span>toggle menu</span>
        </button>
        
        <div class="site-header-content">
            <div class="site-header-content-in">
                <div class="site-header-shown">
                <div class="dropdown dropdown-notification notif">
                        <a href="../MntNotificacion/" class="header-alarm">
                            <i class="font-icon-alarm"></i>
                        </a>
                </div>
                    <div class="dropdown user-menu">
                        <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="../../public/img/<?php echo $_SESSION["id_rol"] ?>.ico" alt="">
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
                            <!--<a class="dropdown-item" href="../MntPerfil/"><span class="font-icon glyphicon glyphicon-user"></span>Perfil</a>-->
                           <!--<a class="dropdown-item" href="#"><span class="font-icon glyphicon glyphicon-question-sign"></span>Ayuda</a>-->
                            <!--<div class="dropdown-divider"></div>-->
                            <a class="dropdown-item" href="../../../PortalNuevaVersion/view/Home/home.php"><span class="font-icon glyphicon glyphicon-log-out"></span>Regresar</a>
                        </div>
                    </div>
                </div>

                <div class="mobile-menu-right-overlay"></div>

                <input type="hidden" id="user_idx" value="<?php echo $_SESSION["id_usuario"] ?>"><!-- ID del Usuario-->
                <input type="hidden" id="rol_idx" value="<?php echo $_SESSION["id_rol"] ?>"><!-- Rol del Usuario-->

                <div class="dropdown dropdown-typical">
                    <a href="#" class="dropdown-toggle no-arr">
                        <span class="font-icon font-icon-user"></span>
                        <span class="lblcontactonomx"><?php echo $_SESSION["nombre"] ?> <?php echo $_SESSION["paterno"] ?></span>
                    </a>
                </div>

            </div>
        </div>
    </div>
</header>