<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RSD | RESIDUOS</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="lib/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="lib/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="lib/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="lib/dist/css/AdminLTE.min.css">
    <!-- css iconos redondos -->
    <link rel="stylesheet" href="lib/iconcurved.css">
    <!-- css tabla scroll dispositivo movil -->
    <link rel="stylesheet" href="lib/table-scroll.css">

    <!-- css sweetalert -->
    <link rel="stylesheet" href="lib/sweetalert/sweetalert.css">
    
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="lib/dist/css/skins/_all-skins.min.css">

    <link rel="stylesheet" href="<?php base_url();?>lib/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css">

    <link rel="stylesheet"
        href="<?php base_url()?>lib/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

        <!-- <link rel="stylesheet"
        href="<?php //base_url()?>lib/bower_components/datatables1/datatables.css"> -->

     

        
        <!-- <link rel="stylesheet"
        href="<?php //base_url()?>lib/bower_components/datatables1/datatables.min.css"> -->

        <!-- Select2 -->
        <link rel="stylesheet" href="<?php base_url()?>lib/bower_components/select2/dist/css/select2.min.css">



    <link rel="stylesheet" href="<?php base_url()?>lib/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <link rel="stylesheet" href="<?php base_url()?>lib/bower_components/bootstrap-daterangepicker/daterangepicker.css">

    <!-- Bootstrap datetimepicker -->
    <link rel="stylesheet" href="<?php base_url();?>lib/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css">

    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php base_url();?>lib/plugins/iCheck/all.css">

    <link rel="stylesheet" href="<?php echo base_url();?>lib/bootstrapValidator/bootstrapValidator.min.css" />

    <!-- alertifyjs -->

    <link rel="stylesheet" href="<?php base_url();?>lib/alertify/css/alertify.css">
    <link rel="stylesheet" href="<?php base_url();?>lib/alertify/css/themes/bootstrap.css">

    <!-- animate.css -->

    <link rel="stylesheet" href="<?php base_url();?>lib/animate/animate.css">
    
    
    <link rel="stylesheet" href="<?php base_url();?>lib/gridstack/gridstack.css">

    <link rel="stylesheet" href="<?php base_url();?>lib/leaflet/leaflet.css">

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <?php $this->load->view('layout/general_scripts')?>

</head>

<?php $this->load->view('layout/wait') ?>

<body class="hold-transition skin-blue sidebar-mini"></body>
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="#" onclick="linkTo()" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><strong><?php echo MNOM ?></strong></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><img src="<?php echo base_url()?>lib\dist\img\Isologo.png" class="brandlogo-image">
        
        </span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

                            <?php

                #$this->load->view('layout/perfil');

                ?>


        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar" style="height: auto;">
            <?php echo $menu ?>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section id="content" class="content">



        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <strong>Version</strong> 2.4.0
        </div>
        <strong>Copyright &copy; 2019 <a href="">RSD</a>.</strong> All rights
        reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <?php 
             
                $this->load->view('layout/Panel_Derecho');
        ?>
        <!-- Tab panes -->
        
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<script>
var link = '';

linkTo('<?php echo DEF_VIEW ?>');

$('.menu .link').on('click', function() {
    link = $(this).data('link');
    linkTo();
});

function linkTo(uri = '') {
    if (link == '' && uri == '') return;
    $('#content').empty();
    $('#content').load('<?php echo base_url() ?>' + (uri == '' ? link : uri));
}

function collapse(e) {
    e = $(e).closest('.box');

    if (e.hasClass('collapsed-box')) {
        $(e).removeClass('collapsed-box');
    } else {
        $(e).addClass('collapsed-box');
    }

}


/* Abre cuadro cargando ajax */
function WaitingOpen(texto) {
    if (texto == '' || texto == null) {
        $('#waitingText').html('Cargando ...');
    } else {
        $('#waitingText').html(texto);
    }
    $('#waiting').fadeIn('slow');
}
/* Cierra cuadro cargando ajax */
function WaitingClose() {
    $('#waiting').fadeOut('slow');
}

/* Abre cuadro cargando ajax */
function wo(texto) {
   WaitingOpen(texto);
}
/* Cierra cuadro cargando ajax */
function wc() {
    WaitingClose();
}
</script>

</body>

</html>