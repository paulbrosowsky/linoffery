<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    {{-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet"> --}}

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
            margin:120px 55px 70px 55px;
        }

        body{
            font-family: 'Source Sans Pro', sans-serif;
            font-size: 13px;
        }

        header { 
            position: fixed; 
            top: -100px; 
            left: 0px; 
            right: 0px;             
            height: 100px;
        }
        footer { 
            position: fixed; 
            bottom: -100px; 
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

        /* .li-pdf-page{
            page-break-after: always;
        }

        .li-pdf-page:last-child { 
            page-break-after: never;
        } */
              
        
    </style>  
</head>
<body>    
    
    <header>
            <table style="width:100%">
                <tr>
                    <td>
                        <img src="{{asset('/storage/build/images/linoffery_logo.png')}}" width="100">
                    </td>
                    <td style="text-align:right">
                        <p>Simensstr.8</p>
                        <p>73326 Uhingen</p>
                        <p>Umsatzsteuer ID: DE12345678 </p>
                    </td>
                </tr>
                <tr>
                    
                </tr>
            </table>
        
    </header>
    <footer></footer>
    
    {{-- Page 1 START --}}
    <div class="">
        <table style="width:100%">
            <tr>
                <th>{{__('Shipper')}}</th>
                <th>{{__('Carrier')}}</th>
            </tr>
            <tr>
                <td>
                    <p>{{$shipper->company->name}}</p>
                    <div style="margin-bottom: .5rem;">
                        <p>{{$shipper->company->address}}</p>
                        <span>{{$shipper->company->postcode}}</span>
                        <span>{{$shipper->company->city}}</span>
                        <p>{{$shipper->company->country}}</p>
                    </div>
                    <div>
                        <small>{{__('Contact')}}</small>
                        <p>{{$shipper->name}}</p>
                        <p>{{$shipper->email}}</p>
                        <p>{{$shipper->phone}}</p>
                    </div>
                </td>

                <td>
                    <p>{{$carrier->company->name}}</p>
                    <div style="margin-bottom: .5rem;">
                        <p>{{$carrier->company->address}}</p>
                        <span>{{$carrier->company->postcode}}</span>
                        <span>{{$carrier->company->city}}</span>
                        <p>{{$carrier->company->country}}</p>
                    </div>
                    <div>
                        <small>{{__('Contact')}}</small>
                        <p>{{$carrier->name}}</p>
                        <p>{{$carrier->email}}</p>
                        <p>{{$carrier->phone}}</p>
                    </div>
                </td>

            </tr>
        </table>
        <hr>

        <h2 style="margin:0;">{{__('Order')}} 12345-12345</h2>

        <table>
            <tr>
                <td style="width: 120px;">{{__('Agreed price')}}:</td>
                <td>
                    <h3 style="margin: 0.5rem 0 0.5rem 0;">{{$order->offer->price}} EUR</h3>
                </td>
            </tr>
            <tr>
                <td>{{__('Offered at')}}:</td>
                <td>{{$order->offer->created_at->format('d.m.Y')}}</td>
            </tr>
            <tr>
                <td>{{__('Offer ID')}}</td>
                <td>OF1234567890</td>
            </tr>
        </table>
        <hr>
        <h3>{{$tender->title}}</h3>
        <table style="margin-bottom:1rem;">
            <tr>
                <td style="width: 120px;">{{__('Category')}}</td>
                <td>{{$tender->category->name}}</td>
            </tr>
            <tr>
                <td>{{__('Published at')}}</td>
                <td>{{date_create_from_format('Y-m-d H:i:s', $tender->published_at)->format('d.m.Y')}}</td>
            </tr>
            <tr>
                <td>{{__('Tender ID')}}</td>
                <td>OF1234567890</td>
            </tr>
        </table>

        <p style="margin-bottom:1rem;">{{$tender->description}}</p>

        <div>
            <strong>{{__('Pickup details')}}</strong>
            <table style="margin-bottom: 1rem;">
                <tr>
                    <td style="width: 160px;">{{__('Address')}}</td>
                    <td>{{$pickup->address}}</td>
                </tr>
                <tr>
                    <td>{{__('Earliest pickup')}}:</td>
                    <td>{{$pickup->earliest_date->format('d.m.Y')}}</td>
                </tr>
                <tr>
                    <td>{{__('Latest pickup')}}:</td>
                    <td>{{$pickup->latest_date->format('d.m.Y')}}</td>
                </tr>
                <tr>
                    <td>{{__('Loading by driver')}}:</td>
                    <td>{{$pickup->loading}}</td>
                </tr>
                <tr>
                    <td>{{__('Latency')}}:</td>
                    <td>{{$pickup->latency}} {{__('Hours')}}</td>
                </tr>
            </table>

        </div>
       

        
        <div>
            <strong>{{__('Delivery details')}}</strong>

            <table>            
                    <tr>
                        <td style="width: 160px;">{{__('Address')}}</td>
                        <td>{{$delivery->address}}</td>
                    </tr>
                    <tr>
                        <td>{{__('Earliest delivery')}}:</td>
                        <td>{{$delivery->earliest_date->format('d.m.Y')}}</td>
                    </tr>
                    <tr>
                        <td>{{__('Latest delivery')}}:</td>
                        <td>{{$delivery->latest_date->format('d.m.Y')}}</td>
                    </tr>
                    <tr>
                        <td>{{__('Loading by driver')}}:</td>
                        <td>{{$delivery->loading}}</td>
                    </tr>
                    <tr>
                        <td>{{__('Latency')}}:</td>
                        <td>{{$delivery->latency}} {{__('Hours')}}</td>
                    </tr>
                </table> 

        </div>
       
            
        <div>
            <strong>{{__('Freight details')}}</strong>
            <ol>
                @foreach($loads as $load)
                <li style="margin-bottom:1rem;">
                    <strong>{{$load->title}}</strong>
                    <p>{{$load->description}}</p>
                    <table>
                        <tr>
                            <td style="width: 120px;">{{__('Transport type')}}:</td>
                            <td>{{$load->pallet}}</td>
                        </tr>
                        <tr>
                            <td>{{__('Dimentions')}}:</td>
                            <td>
                                {{$load->width.' x '.$load->depth.' x '.$load->height}} cm
                            </td>
                        </tr>
                        <tr>
                            <td>{{__('Weight')}}:</td>
                            <td>{{$load->weight}} kg</td>
                        </tr>

                    </table>
                </li>
                @endforeach
            </ol>

        </div>
       
    </div>
    {{-- Page 2 END --}}
    
</body>
</html>