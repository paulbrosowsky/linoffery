<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
         <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>linoffery</title>

        <!-- Fonts -->     
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600&display=swap" rel="stylesheet">
        <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
        <link href="/css/app.css" rel="stylesheet">

        <style>
            [v-cloak] {
                display: none;
            }
        </style>
      
        <script>
            window.App = {!! json_encode([
                'csrfToken' => csrf_token(),                
            ]) !!};
        </script>       
    </head>
    <body>
            <div id="app"> 
                <app><app>
            </div>
        
       <script src="/js/app.js"></script>
    </body>
</html>
