@extends('layouts.masterhome')

@section('css')
    <!-- Bootstrap Core CSS -->
    <link href="{{ ('/disp-biro-eko/public/ample/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="{{ ('/disp-biro-eko/public/ample/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{{ ('/disp-biro-eko/public/ample/css/animate.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ ('/disp-biro-eko/public/ample/css/style.css') }}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{ ('/disp-biro-eko/public/ample/css/colors/blue-dark.css') }}" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
@endsection

<!-- /////////////////////////////////////////////////////////////// -->

@section('content')
    <style type="text/css">
        #li_portal a.active {
            background:white;
        }
    </style>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title"><?php 
                                                $link = explode("/", url()->full());    
                                                echo str_replace('%20', ' ', ucwords(explode("?", $link[4])[0]));
                                            ?> </h4> </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                    <ol class="breadcrumb">
                        <li>{{env('app_breadcrumb')}}</li>
                        <?php 
                            $link = explode("/", url()->full());
                            if (count($link) == 5) {
                                ?> 
                                    <li class="active"> {{ ucwords(explode("?", $link[4])[0]) }} </li>
                                <?php
                            } elseif (count($link) == 6) {
                                ?> 
                                    <li class="active"> {{ ucwords($link[4]) }} </li>
                                    <li class="active"> {{ ucwords($link[5]) }} </li>
                                <?php
                            } 
                        ?>   
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-sm-12">
                    @if(Session::has('message'))
                        <div class="alert <?php if(Session::get('msg_num') == 1) { ?>alert-success<?php } else { ?>alert-danger<?php } ?> alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: white;">&times;</button>{{ Session::get('message') }}</div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <div class="row row-in">
                            <a href="#">
                            <div class="col-md-4 col-sm-4 row-in-br">
                                <ul class="col-in">
                                    <li>
                                        <span class="circle circle-md bg-info"><i class="ti-user"></i></span>
                                    </li>
                                    <li class="col-last"><h3 class="counter text-right m-t-15">0</h3></li>
                                    <li class="col-middle">
                                        <h4>Angka</h4>
                                    </li>
                                    
                                </ul>
                            </div>
                            </a>
                            <a href="#">
                            <div class="col-md-4 col-sm-4 row-in-br">
                                <ul class="col-in">
                                    <li>
                                        <span class="circle circle-md bg-danger"><i class="ti-user"></i></span>
                                    </li>
                                    <li class="col-last"><h3 class="counter text-right m-t-15">0</h3></li>
                                    <li class="col-middle">
                                        <h4>Angka</h4>
                                    </li>
                                    
                                </ul>
                            </div>
                            </a>
                            <a href="#">
                            <div class="col-md-4 col-sm-4 row-in-br">
                                <ul class="col-in">
                                    <li>
                                        <span class="circle circle-md bg-success"><i class="ti-user"></i></span>
                                    </li>
                                    <li class="col-last"><h3 class="counter text-right m-t-15">0</h3></li>
                                    <li class="col-middle">
                                        <h4>Angka</h4>
                                    </li>
                                    
                                </ul>
                            </div>
                            </a>
                            
                            <!-- <div class="col-md-3 col-sm-6">
                                <ul class="col-in">
                                    <li>
                                        <span class="circle circle-md bg-warning"><i class="fa fa-dollar"></i></span>
                                    </li>
                                    <li class="col-last"><h3 class="counter text-right m-t-15">83</h3></li>
                                    <li class="col-middle">
                                        <h4>Net Earnings</h4>
                                    </li>
                                </ul>
                            </div> --> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    
                </div>
            </div>
            
        </div>
        <!-- /.container-fluid -->
        <footer class="footer text-center"> 2017 &copy; Ample Admin brought to you by themedesigner.in </footer>
    </div>
    
@endsection

<!-- /////////////////////////////////////////////////////////////// -->

@section('js')
    <script src="{{ ('/disp-biro-eko/public/ample/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="{{ ('/disp-biro-eko/public/ample/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="{{ ('/disp-biro-eko/public/ample/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
    <!--slimscroll JavaScript -->
    <script src="{{ ('/disp-biro-eko/public/ample/js/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ ('/disp-biro-eko/public/ample/js/waves.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ ('/disp-biro-eko/public/ample/js/custom.min.js') }}"></script>
    <!--Style Switcher -->
    <script src="{{ ('/disp-biro-eko/public/ample/plugins/bower_components/styleswitcher/jQuery.style.switcher.js') }}"></script>
@endsection
