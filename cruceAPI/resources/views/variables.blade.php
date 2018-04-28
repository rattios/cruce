<!DOCTYPE html>
<html>
    <head>
        <title>Demo Indicadores</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
                background-image: url('https://www.mactualidad.com/wp-content/uploads/2014/07/smooth-blaze.jpg');
                background-size: cover;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 50px;
                color: #3a0823;
            }

            .content-form{
                background-color: rgba(0,0,0,0.8);
                padding: 50px 60px;
                border-radius: 3px;
                min-width: 400px;
            }

            .input-form{
                margin-bottom: 30px;
                background-color: transparent;
                height: 45px;
                padding-left: 40px;
                color: #fff;
                font-size: 18px;
            }

            .button-login{
                width: 100%;
                background-color: #0a0a09;
                color: #fff;
                font-size: 18px;
                text-transform: uppercase;
                font-weight: 600;
            }

            form{
                display: block;
                position: relative;
            }

            .icon-input{
                color: #cccccc;
                position: absolute;
                left: 15px;
                top: 13px;
                font-size: 19px;
            }
            .form-group {
                display: block;
                position: relative;
            }

            .triangle {
              display: inline-block;
              margin: auto;
              vertical-align: middle;
            }

            .triangle-4 {
              width: 30px;
              height: 30px;
              border-bottom: solid 25px rgba(0,0,0,0.8);
              border-left: solid 25px transparent;
              border-right: solid 25px transparent;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <p>Por favor corrige los errores:</p>

                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="title">CONFIGURACIÓN <br>DE LA BASE DE DATOS</div>
                <div class="triangle triangle-4"></div>
                <div class="content-form">
                    <form method="POST">
                        <div class="form-group">
                            <i class="fa fa-database icon-input" aria-hidden="true"></i>
                            <input class="form-control input-form" type="text" name="DB_DATABASE" id="DB_DATABASE" placeholder="NOMBRE DE BASE DE DATOS">
                        </div>
                        <div class="form-group">
                            <i class="fa fa-user icon-input" aria-hidden="true"></i>
                            <input type="text" class="form-control input-form" name="DB_USERNAME" id="DB_USERNAME" placeholder="USER">
                        </div>
                        <div class="form-group">
                            <i class="fa fa-lock icon-input" aria-hidden="true"></i>
                            <input type="text" class="form-control input-form" name="DB_PASSWORD" id="DB_PASSWORD" placeholder="PASSWORD">
                        </div>
                        <button class="btn button-login">GUARDAR</button>
                        
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
