<?php
session_start();

if(isset($_SESSION['sesion_email'])){
   // echo "el usuarios paso por el login";
    $email_sesion = $_SESSION['sesion_email'];
    $query_sesion = $pdo->prepare("SELECT * FROM usuarios as usu
                                    INNER JOIN roles as rol ON rol.id_rol = usu.rol_id 
                                    INNER JOIN personas as per ON per.usuario_id = usu.id_usuario
                                    WHERE usu.email = '$email_sesion' AND usu.estado = '1' ");
    $query_sesion->execute();

    $datos_sesion_usuarios = $query_sesion->fetchAll(PDO::FETCH_ASSOC);
    foreach ($datos_sesion_usuarios as $datos_sesion_usuario){
       $nombre_sesion_usuario = $datos_sesion_usuario['email'];
       $id_rol_sesion_usuario = $datos_sesion_usuario['id_rol'];
       $rol_sesion_usuario = $datos_sesion_usuario['nombre_rol'];
       $nombres_sesion_usuario = $datos_sesion_usuario['nombres'];
       $apellidos_sesion_usuario = $datos_sesion_usuario['apellidos'];
       $ci_sesion_usuario = $datos_sesion_usuario['ci'];
    }

    $url = $_SERVER["PHP_SELF"];
    $conta = strlen($url);
    $rest = substr($url, 18, $conta);


    $sql_roles_permisos = "SELECT * FROM roles_permisos as rolper 
                       INNER JOIN permisos as per ON per.id_permiso = rolper.permiso_id 
                       INNER JOIN roles as rol ON rol.id_rol = rolper.rol_id 
                       where rolper.estado = '1' ";
    $query_roles_permisos = $pdo->prepare($sql_roles_permisos);
    $query_roles_permisos->execute();
    $roles_permisos = $query_roles_permisos->fetchAll(PDO::FETCH_ASSOC);
    $contadorpermiso = 0;
    foreach ($roles_permisos as $roles_permiso){
        if($id_rol_sesion_usuario == $roles_permiso['rol_id']){
            //echo $roles_permiso['url'];
            if($rest == $roles_permiso['url']){
                // echo "permiso autorizado - ";
                $contadorpermiso = $contadorpermiso + 1;
            }else{
                // echo "no autorizadó";
            }

        }
    }
    if($contadorpermiso>0){
        //echo "ruta autorizada";
        //echo $rest;
    }else{
        //echo "usuario no autorizadó";
        //echo $rest;
        header('Location:'.APP_URL."/admin/no-autorizado.php");
    }




}else{
    echo "el usuario no paso por el login";
    header('Location:'.APP_URL."/login");
}
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=APP_NAME;?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?=APP_URL;?>/public/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=APP_URL;?>/public/dist/css/adminlte.min.css">

    <!-- jQuery -->
    <script src="<?=APP_URL;?>/public/plugins/jquery/jquery.min.js"></script>

    <!-- Sweetaler2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Iconos de bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Datatables -->
    <link rel="stylesheet" href="<?=APP_URL;?>/public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?=APP_URL;?>/public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?=APP_URL;?>/public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- CHART -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="<?=APP_URL;?>/admin" class="nav-link"><?=APP_NAME;?></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                    <i class="fas fa-th-large"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="<?=APP_URL;?>/admin" class="brand-link">
            <img src="https://cdn-icons-png.flaticon.com/512/5526/5526487.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">GESTIÓN ESCOLAR</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="https://cdn-icons-png.flaticon.com/512/6073/6073873.png" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block"><?=$nombre_sesion_usuario;?></a>
                </div>
            </div>


            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->

                    <?php
                    if( ($rol_sesion_usuario=="ADMINISTRADOR") || ($rol_sesion_usuario=="DIRECTOR ACADÉMICO") || ($rol_sesion_usuario=="DIRECTOR ADMINISTRATIVO")){ ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas"><i class="bi bi-gear"></i></i>
                                <p>
                                    Configuraciones
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=APP_URL;?>/admin/configuraciones" class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Configurar</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php
                    }
                    ?>


                    <?php
                    if( ($rol_sesion_usuario=="ADMINISTRADOR") || ($rol_sesion_usuario=="DIRECTOR ACADÉMICO") ){ ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas"><i class="bi bi-bookshelf"></i></i>
                                <p>
                                    Niveles
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=APP_URL;?>/admin/niveles" class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Listado de niveles</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas"><i class="bi bi-bar-chart-steps"></i></i>
                                <p>
                                    Grados
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=APP_URL;?>/admin/grados" class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Listado de grados</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas"><i class="bi bi-book-half"></i></i>
                                <p>
                                    Materias
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=APP_URL;?>/admin/materias" class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Listado de materias</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php
                    }
                    ?>




                    <?php
                    if( ($rol_sesion_usuario=="ADMINISTRADOR") ){ ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas"><i class="bi bi-bookmarks"></i></i>
                                <p>
                                    Roles
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=APP_URL;?>/admin/roles" class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Listado de roles</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=APP_URL;?>/admin/roles/permisos.php" class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Listado de Permisos</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas"><i class="bi bi-people-fill"></i></i>
                                <p>
                                    Usuarios
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=APP_URL;?>/admin/usuarios" class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Listado de usuarios</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php
                    }
                    ?>





                    <?php
                    if( ($rol_sesion_usuario=="ADMINISTRADOR") || ($rol_sesion_usuario=="DIRECTOR ACADÉMICO") || ($rol_sesion_usuario=="DIRECTOR ADMINISTRATIVO") || ($rol_sesion_usuario=="SECRETARIA")){ ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas"><i class="bi bi-person-lines-fill"></i></i>
                                <p>
                                    Administrativos
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=APP_URL;?>/admin/administrativos" class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Listado de administrativos</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php
                    }
                    ?>



                    <?php
                    if( ($rol_sesion_usuario=="ADMINISTRADOR") || ($rol_sesion_usuario=="DIRECTOR ACADÉMICO") || ($rol_sesion_usuario=="SECRETARIA")){ ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas"><i class="bi bi-person-video3"></i></i>
                                <p>
                                    Docentes
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=APP_URL;?>/admin/docentes" class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Listado de docentes</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=APP_URL;?>/admin/docentes/asignacion.php" class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Asignación de materias</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php
                    }
                    ?>




                    <?php
                    if( ($rol_sesion_usuario=="ADMINISTRADOR") || ($rol_sesion_usuario=="DOCENTE") ){ ?>
                        <li class="nav-item">
                            <a href="<?=APP_URL;?>/admin/kardex" class="nav-link active">
                                <i class="nav-icon fas"><i class="bi bi-clipboard-check"></i></i>
                                <p>
                                    Kardex
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=APP_URL;?>/admin/calificaciones" class="nav-link active">
                                <i class="nav-icon fas"><i class="bi bi-check2-square"></i></i>
                                <p>
                                    Calificaciones
                                </p>
                            </a>
                        </li>
                        <?php
                    }
                    ?>





                    <?php
                    if( ($rol_sesion_usuario=="ADMINISTRADOR") || ($rol_sesion_usuario=="DIRECTOR ACADÉMICO") || ($rol_sesion_usuario=="DIRECTOR ADMINISTRATIVO") || ($rol_sesion_usuario=="SECRETARIA")|| ($rol_sesion_usuario=="CONTADOR")){ ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas"><i class="bi bi-person-video"></i></i>
                                <p>
                                    Estudiantes
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=APP_URL;?>/admin/inscripciones" class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Inscripción</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=APP_URL;?>/admin/estudiantes" class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Listado de estudiantes</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php
                    }
                    ?>



                    <?php
                    if( ($rol_sesion_usuario=="ADMINISTRADOR") || ($rol_sesion_usuario=="DIRECTOR ADMINISTRATIVO") || ($rol_sesion_usuario=="CONTADOR")){ ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas"><i class="bi bi-cash-coin"></i></i>
                                <p>
                                    Pagos
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=APP_URL;?>/admin/pagos" class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Realizar pago</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php
                    }
                    ?>



                    <li class="nav-item">
                        <a href="<?=APP_URL;?>/login/logout.php" class="nav-link" style="background-color: #eb2d14;color: black">
                            <i class="nav-icon fas"><i class="bi bi-door-open"></i></i>
                            <p>
                                Cerrar sesión
                            </p>
                        </a>
                    </li>


                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>