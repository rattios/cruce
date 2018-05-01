<!DOCTYPE html>
<html>
    <head>
        <title>Login Indicadores</title>

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
                padding: 45px 40px;
                margin-top: 20px;
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
                
                <div class="title">Has configurado exitosamente la api de indicadores.</div>

                
            </div>
        </div>
    </body>
</html>
