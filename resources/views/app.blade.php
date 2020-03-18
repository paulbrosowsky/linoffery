<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">         
       

        <title>linoffery</title>

        <!-- Fonts -->     
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600&display=swap" rel="stylesheet">
        <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        <style>
            [v-cloak] {
                display: none;
            }
        </style>
        <script src="https://js.stripe.com/v3/"></script>
        <script>            
            var Linoffery = {  
                url: "{{ config('app.url') }}", 
                csrfToken: "{{ csrf_token() }}",  
                mapsKey: "{{ config('services.maps.key') }}"                 
            }                    
        </script>       
    </head>
    <body>
        <div id="app"> 
            <app><app>
        </div>
        
        <script src="{{ mix('js/app.js') }}"></script>      
    </body>
</html>
