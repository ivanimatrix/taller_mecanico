<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo \pan\App::getAppName()?> | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php \pan\Uri::getHost()?>pub/others/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php \pan\Uri::getHost()?>pub/others/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php \pan\Uri::getHost()?>pub/others/adminlte/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php \pan\Uri::getHost()?>pub/others/adminlte/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php \pan\Uri::getHost()?>pub/others/adminlte/plugins/iCheck/square/blue.css">

    <!-- CSS principal -->
    <link rel="stylesheet" href="<?php \pan\Uri::getHost()?>pub/css/main.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,700italic,400,300,700">
</head>
<body class="hold-transition login-page">
<div class="login-box">

    <div class="box box-widget widget-user-2">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-blue">
            <div class="widget-user-image">
                <i class="fa fa-sign-in fa-5x pull-left"></i>
            </div>
            <!-- /.widget-user-image -->
            <h3 class="widget-user-username">Taller Mecánico Esperanza</h3>
            <h5 class="widget-user-desc">Inicio de sesión</h5>
        </div>
        <div class="box-footer no-padding">
            <div class="login-box-body">
                <p class="login-box-msg">Ingrese sus datos para comenzar su sesión</p>

                <form action="" method="post">
                    <div class="form-group has-feedback">
                        <input type="text" name="rut" id="rut" class="form-control" placeholder="Rut, ej:12345678-9">
                        <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="pass" id="pass" class="form-control" placeholder="Contraseña">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-7">
                            <a href="javascript:void(0);" onclick="Login.solicitarPassword();">¿Olvidó su contraseña?</a><br>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-5">
                            <button type="button" class="btn btn-primary btn-block btn-flat" onclick="Login.loginUsuario(this.form, this);">Ingresar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>



            </div>
        </div>
    </div><!-- /.login-logo -->




    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php \pan\Uri::getHost()?>pub/others/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php \pan\Uri::getHost()?>pub/others/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php \pan\Uri::getHost()?>pub/others/adminlte/plugins/iCheck/icheck.min.js"></script>

<!-- base -->
<script src="<?php \pan\Uri::getHost()?>pub/js/base.js" type="text/javascript"></script>

<!-- modal -->
<script src="<?php \pan\Uri::getHost()?>pub/js/helpers/modal.js" type="text/javascript"></script>

</body>
</html>
