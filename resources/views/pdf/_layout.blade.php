<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>       

        <style>      

            @font-face {
                font-family: 'Source Sans Pro';
                src: url("{{storage_path('/fonts/SourceSansPro-Regular.ttf')}}") format("truetype");
                font-weight: normal; 
                font-style: normal; 
            }

            @font-face {
                font-family: 'Source Sans Pro';
                src: url("{{storage_path('/fonts/SourceSansPro-Bold.ttf')}}") format("truetype");
                font-weight: bold; 
                font-style: normal; 
            }        
            
            @page {                
                margin:100px 55px 70px 55px;
            }

            body{
                font-family: 'Source Sans Pro', sans-serif;
                font-size: 13px;
            }

            header { 
                position: fixed; 
                top: -70px; 
                left: 0px; 
                right: 0px;             
                height: 50px;
            }
            footer { 
                position: fixed; 
                bottom:-20px; 
                left: 0px; 
                right: 0px; 
                
                height: 50px; 
            }

            p{
                margin: 0;                          
            }          
            
            th{
                text-align: left; 
            }

            hr{
                border:1px solid #e0e0e0;
                margin: 1rem 0 1rem 0
            }   
            b{
                margin-bottom: 1rem;
            }                
            
        </style>  
    </head>
    <body>         
        <header>            
            @yield('header')
        </header>    

        <table style="width:100%; margin-bottom: 4rem">
            <tr>
                <td style="vertical-align:bottom">
                    <p style="font-size: 0.75em; margin-bottom:0.75rem">
                        <span>linoffery </span>&middot;<span> Kirchstraße 35 </span>&middot;<span> 89555 Steinheim am Almbuch</span>
                    </p>

                    @yield('receiver')
                </td>
                <td style="text-align:right">
                    <img src="{{asset('/storage/build/images/linoffery_logo.png')}}" width="160">
                    <p style="margin-bottom: 1rem">
                        <span>Die smarte</span>
                        <span style="color: #38b2ac">Logistikplattform</span>
                    </p>
                    <p>Kirchstraße 35</p>
                    <p>89555 Steinheim am Almbuch</p>
                    <p>Mob: +49(0)176 64787862</p>
                    <p>Tel: +49(0)7161 9661846</p>
                    <p>Email: info@linoffery.com</p>
                </td>
            </tr>           
        </table>      
        
        @yield('content')

        <footer>
            <table style="width:100%">
                <tr>
                    <td>
                        <p>Linoffery</p>
                        <p>Kirchstraße 35</p>
                        <p>89555 Steinheim am Almbuch</p>
                    </td>
                    <td>
                        <p>Sparkasse Göppingen</p>                        
                        <p>IBAN: DE84 6105 0000 0049 0864 01</p>
                        <p>BIC: GOPSDE6GXXX</p>
                    </td>
                    <td style="vertical-align:top">
                        <p>Steuer-Nr.: 64339/11447</p>  
                        <p>Finanzamt Heidenheim</p>  
                    </td>
                    
                </tr>
            </table>
        </footer>  
    </body>
</html>   