<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Mail,Im in list</title>

        </style>
    </head>
    <body>
    <h2>Enviado por: {{ $email }}</h2>
    <hr>
    <p>{{ $mensaje }}</p>
    


    </body>
</html>
