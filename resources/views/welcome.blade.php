<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login</title>

        <link rel="stylesheet" href="{{ asset('plugins/pace/pace-theme-flash.css')}}"  type="text/css" media="screen"/>
        <link rel="stylesheet" href="{{ asset('plugins/boostrapv3/css/bootstrap.min.css')}}"  type="text/css"/>
        <link rel="stylesheet" href="{{ asset('css/style.css')}}" type="text/css"/>
        <style type="text/css">
            /* Change the white to any color ;) */
            input:-webkit-autofill {
                -webkit-box-shadow: 0 0 0px 1000px white inset !important;
                -webkit-text-fill-color: #245F50 !important;
            }
            @font-face {
                font-family: "Gill Sans Light";
                src: url({{asset('fonts/gill-sans/GillSansStd-Light.otf')}}) format("opentype");
            }
            .body-login {
                background: url('{{asset('img/bg_login.png')}}');
                background-size: 100% 100%;
                background-repeat: no-repeat;
            }
            input::placeholder, h1.login-header {
                font-family: "Gill Sans Light"!important;
                color: #245F50!important;
                font-size: 20px;
            }
            input:focus{
                border: 0;
                outline: 0;
                background-color: transparent!important;
                border-bottom: 2px solid #245F50!important;
            }
            input[type="text"], input[type="password"] {
                font-size:20px;
                font-family: "Gill Sans Light"!important;
                color: #245F50!important;
                height: 20px !important;
            }
            h1.login-header {
                color: #C1DF7B!important;
                font-size: 4.5em;
                padding-top: 0.5em;
                padding-bottom: 20px;
            }
            input.form-control {
                background-color: transparent;
                border: 0;
                outline: 0;
                border-bottom: 2px solid #245F50;
            }
            button{
                margin-top: 2.5em;
                font-weight: bold;
                width: 260px;
                border: none;
                background: #94D402;
                color: #f2f2f2;
                padding: 10px;
                font-size: 18px;
                position: relative;
                box-sizing: border-box;
                transition: all 500ms ease;
            }
            button:hover {
                cursor: pointer;
                background: rgba(0,0,0,0);
                color: #94D402;
                box-shadow: inset 0 0 0 3px #94D402;
            }
            img#logo-company{
                padding-top: 50px;
                width: 35%;
            }
            .show-error{
                font-size: 12px;
                color: maroon;
                display: block;
                margin-top: 2%;
                margin-bottom: 3%;
            }
            #form-container{
                opacity: .8;
                background-color: white;
                padding: 10px;
                margin: -20px;
            }
        </style>
    </head>
    <body class="body-login">
        <div class="">
            <div class="col-lg-12 text-center">
                <div class="col-xs-12 col-sm-8 col-sm-push-2 col-sm-pull-2 col col-md-6 col-md-push-3 col-md-pull-3">
                    <div class="p-t-20 p-l-15 p-r-15 p-b-30">
                        <img id="logo-company" src="{{asset('img/company_logo.png')}}">
                        <div id="form-container-simpleverde">
                            <h1 class="login-header">BIENVENIDO</h1>
                            <form class="m-t-30 m-l-15 m-r-15" method="POST" action="login" autocomplete="off">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <input type="text" class="form-control" id="user" name="user" placeholder="Usuario">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
                                </div>
                                <button class="m-t-10" type="submit"><i class="icon-cloud-download"></i>INGRESAR</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/jquery.js') }}"></script>
        <script src="{{ asset('js/sweetalert.min.js') }}"></script>
        <script src="{{ asset('plugins/boostrapv3/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/pace/pace.min.js') }}" type="text/javascript"></script>
    </body>
</html>
