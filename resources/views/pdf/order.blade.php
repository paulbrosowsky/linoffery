@extends('pdf._layout')   

@section('header')
    <p>{{__('Order').': '.$order->custom_id}}</p>
@endsection

@section('receiver')
    <p>{{$receiver->name}}</p>   
    <p>{{$receiver->address}}</p> 
    <p>{{$receiver->postcode .' '. $receiver->city}}</p> 
    <p>{{$receiver->country}}</p> 
@endsection
    
@section('content')
    <h1>{{__('Order')}}</h1>

    <table style="width:100%; margin-bottom: 1.5rem">
        <tr>
            <td>                
                <p style="font-size: 1.2em">{{__('Order').' Nr.: '. $order->custom_id}}</p>
                <p style="font-style: italic; font-size: 0.8em;">{{__('Please specify when making payments and correspondence')}}</p>
            </td>
            <td style="text-align:right; vertical-align:top">
                <p>{{__('Date') .': '.  $order->created_at->format('d-m-Y')}}</p>
            </td>
        </tr>
    </table>

    <p>{{__('Thank you for using our platform.').' '.__('Enclosed you will receive the information about your new mediation order.')}}</p>

    <table style="width:100%; margin-top: 2rem">
        <tr>
            <th>{{__('Shipper')}}</th>
            <th>{{__('Carrier')}}</th>
        </tr>
        <tr>
            <td>
                <p>{{$order->tenderer->company->name}}</p>
                <div style="margin-bottom: .5rem;">
                    <p>{{$order->tenderer->company->address}}</p>
                    <span>{{$order->tenderer->company->postcode}}</span>
                    <span>{{$order->tenderer->company->city}}</span>
                    <p>{{$order->tenderer->company->country}}</p>
                </div>
                <div>
                    <small>{{__('Contact')}}</small>
                    <p>{{$order->tenderer->name}}</p>
                    <p>{{$order->tenderer->email}}</p>
                    <p>{{$order->tenderer->phone}}</p>
                </div>
            </td>

            <td>
                <p>{{$order->carrier->company->name}}</p>
                <div style="margin-bottom: .5rem;">
                    <p>{{$order->carrier->company->address}}</p>
                    <span>{{$order->carrier->company->postcode}}</span>
                    <span>{{$order->carrier->company->city}}</span>
                    <p>{{$order->carrier->company->country}}</p>
                </div>
                <div>
                    <small>{{__('Contact')}}</small>
                    <p>{{$order->carrier->name}}</p>
                    <p>{{$order->carrier->email}}</p>
                    <p>{{$order->carrier->phone}}</p>
                </div>
            </td>

        </tr>
    </table>

    {{-- <hr>   --}}


    <table style="page-break-after: always" >
        <tr>
            <td style="width: 120px">{{__('Agreed price')}}:</td>
            <td>
                <h3 style="font-size: 1.2em; margin: 0.5rem 0 0.5rem 0;">{{$order->offer->price}} EUR</h3>
            </td>
        </tr>
        <tr>
            <td>{{__('Offered at')}}:</td>
            <td>{{$order->offer->created_at->format('d.m.Y')}}</td>
        </tr>
        <tr>
            <td>{{__('Offer Nr.')}}</td>
            <td>{{$order->offer->custom_id}}</td>
        </tr>
    </table>
  
    <h3>{{$order->tender->title}}</h3>

    <table style="margin-bottom:1rem;">
        <tr>
            <td style="width: 120px;">{{__('Category')}}</td>
            <td>{{$order->tender->category->name}}</td>
        </tr>
        <tr>
            <td>{{__('Published at')}}</td>
            <td>{{date_create_from_format('Y-m-d H:i:s', $order->tender->published_at)->format('d.m.Y')}}</td>
        </tr>
        <tr>
            <td>{{__('Tender Nr.')}}</td>
            <td>{{$order->tender->custom_id}}</td>
        </tr>
    </table>
<p style="margin-bottom:1rem;">{{$order->tender->description}}</p>

<div style="margin-bottom:1rem;">
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
            <td>{{__('Loading time')}}:</td>
            <td>{{__('from')}} {{$pickup->loading_start}} {{__('to')}} {{$pickup->loading_end}}</td>
        </tr>

        <tr>
            <td>{{__('Loading by driver')}}:</td>
            <td>{{$pickup->loading}}</td>
        </tr>

        <tr>
            <td>{{__('Exchange loading equipment')}}:</td>
            <td>{{$pickup->exchange_pallet}}</td>
        </tr>
    </table>

    <strong>{{__('Delivery details')}}</strong>

    <table style="margin-bottom: 2rem">
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
            <td>{{__('Loading time')}}:</td>
            <td>{{__('from')}} {{$delivery->loading_start}} {{__('to')}} {{$delivery->loading_end}}</td>
        </tr>

        <tr>
            <td>{{__('Loading by driver')}}:</td>
            <td>{{$delivery->loading}}</td>
        </tr>

        <tr>
            <td>{{__('Exchange loading equipment')}}:</td>
            <td>{{$delivery->exchange_pallet}}</td>
        </tr>
    </table>

    <strong>{{__('Freight details')}}</strong>
    <ol>
        @foreach($order->tender->freights as $load)
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
@endsection
