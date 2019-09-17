<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">         
       

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
        <script src="https://js.stripe.com/v3/"></script>
        <script>            
            var Linoffery = {   
                csrfToken: "{{ csrf_token() }}",           
                stripeKey: "{{ config('services.stripe.key') }}"                
            }  
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
                (function(){
                    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                    s1.async=true;
                    s1.src='https://embed.tawk.to/5d7fe6d0c22bdd393bb6215b/default';
                    s1.charset='UTF-8';
                    s1.setAttribute('crossorigin','*');
                    s0.parentNode.insertBefore(s1,s0);
                })();        
        </script>       
    </head>
    <body>
        <div id="app"> 
            <app><app>
        </div>
        
        <script src="/js/app.js"></script>      
    </body>
</html>
