<!DOCTYPE html>

<html lang="en" >
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>HUD</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    <!-- Begin Parent Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="favicon.ico" />
    @yield('styles')
    <!-- End Parent Styles -->
</head>
<!-- END HEAD -->

<!-- Begin Nav Bar -->
<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle navbar-toggle-sidebar collapsed">
                MENU
            </button>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">
                Administrator
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <form class="navbar-form navbar-left" method="GET" role="search">
                <div class="form-group">
                    <input type="text" name="q" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/" target="_blank">Visit Site</a></li>
                <li class="dropdown ">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        Account
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li class="dropdown-header">SETTINGS</li>
                        <li class=""><a href="#">Other Link</a></li>
                        <li class=""><a href="#">Other Link</a></li>
                        <li class=""><a href="#">Other Link</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<!-- End Nav Bar -->

<!-- Begin Container -->
<div class="container-fluid main-container">

    <!-- Begin Sidebar -->
    <?php   $ActionName= strtok(strstr(Route::getCurrentRoute()->uri(),"/"), '/' ); ?>

    <div class="col-md-2 sidebar">
        <div class="row">
            <!-- uncomment code for absolute positioning tweek see top comment in css -->
            <div class="absolute-wrapper"> </div>
            <!-- Menu -->
            <div class="side-menu">
                <nav class="navbar navbar-default" role="navigation">
                    <!-- Main Menu -->
                    <div class="side-menu-container">
                        <ul class="nav navbar-nav">


                            @if($ActionName == 'index' || $ActionName == '')
                                <li class="active">
                            @else
                                <li class="">
                            @endif
                                <a href="/admin"><span class="glyphicon glyphicon-dashboard"></span> Dashboard</a>
                            </li>


                            @if($ActionName == 'admins'  )
                                <li class="active">
                            @else
                                <li class="">
                            @endif
                            <a href="/admin/admins"><span class="glyphicon glyphicon-user"></span> Admins</a>
                            </li>



                            <li><a href="{{ route("logout") }}"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>

                        </ul>
                    </div><!-- /.navbar-collapse -->
                </nav>
            </div>

        </div>
    </div>
    <!-- End Sidebar -->

    <!-- Begin Content -->
    @yield('content')
    <!-- End Content -->

</div><!-- End Container -->

<footer class="pull-left footer">
    <p class="col-md-12">
    <hr class="divider">
    Copyright &COPY; 2017 <a href="/">HUD</a>
    </p>
</footer>



<!-- Begin Parent Java scripts -->
<script href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"> </script>
<script href="{{url('js/test.js')}}"></script>
@yield('javascripts')
<!-- End Parent Java scripts -->