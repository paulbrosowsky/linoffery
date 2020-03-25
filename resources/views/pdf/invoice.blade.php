@extends('pdf._layout')

@php
    $deCustomer = preg_match('/^(DE|de)/', $receiver->vat) 
@endphp


@section('header')
    <p>{{__('Invoice').': '.$invoice->custom_id}}</p>
@endsection

@section('receiver')
    <p>{{$receiver->name}}</p>   
    <p>{{$receiver->address}}</p> 
    <p>{{$receiver->postcode .' '. $receiver->city}}</p> 
    <p>{{$receiver->country}}</p>      
    @if (! $deCustomer)
        <p>{{__('VAT ID')}}: {{$receiver->vat}}</p>  
    @endif
@endsection

@section('content')
    {{-- <p style="page-break-after: always">{{$invoice}}</p> --}}
    <h1>{{__('Invoice')}}</h1>

    <table style="width:100%; margin-bottom: 1.5rem">
        <tr>
            <td>                
                <p style="font-size: 1.2em">{{__('Invoice').' Nr.: '. $invoice->custom_id}}</p>
                <p style="font-style: italic; font-size: 0.8em;">{{__('Please specify when making payments and correspondence')}}</p>
            </td>
            <td style="text-align:right; vertical-align:top">
                <p>{{__('Date') .': '.  $invoice->created_at->format('d-m-Y')}}</p>
            </td>
        </tr>
    </table>

    <p>{{__('Thank you for using our platform.').' '.__('As agreed, we will invoice the following service.')}}</p>

    <table style="width:100%; margin-top: 2rem; margin-bottom: 2rem">
        <thead>
            <tr>
                <th>{{__('Pos')}}</th>
                <th>{{__('Date')}}</th>
                <th>{{__('Loading Nr.')}}</th>
                <th>{{__('Mediation Nr.')}}</th>
                <th>{{__('Price in EUR')}}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>{{$invoice->order->created_at->format('d-m-Y')}}</td>
                <td>{{$invoice->order->tender->custom_id}}</td>
                <td>{{$invoice->order->custom_id}}</td>
                <td>{{$invoice->order->offer->price}} EUR</td>
            </tr>

            <tr>
                <td colspan="4">{{__('Amount of the agency fee incurred')}}</td>
                <td>{{config('linoffery.payment.standard')}} %</td>
            </tr>
            <tr>
                <td colspan="4">{{__('Net amount')}}</td>
                <td>{{ number_format($invoice->order->cost , 2, ',', ' ') }} EUR</td>
            </tr>
            <tr>
                <td colspan="4">{{__('VAT')}}</td>
                @if($deCustomer)
                    <td>19 %</td>
                @else
                    <td>{{__('Reverse charge procedure')}}</td>
                @endif
            </tr>
            <tr style="font: bold">
                <td colspan="4">{{__('Invoice amount')}}</td>
                @if ($deCustomer)
                    <td>{{ number_format($invoice->order->cost*1.19 , 2, ',', ' ')}} EUR</td>
                @else
                    <td>{{ number_format($invoice->order->cost , 2, ',', ' ') }} EUR</td>
                @endif
            </tr>
        </tbody>  
    </table>    

    
    <p>
        <span>{{__('The invoice has to be paid immediately.')}}</span>
        <span>{{__('Please use our payment options at this link:')}}</span>
    </p>
    <p style="margin-top: 1rem; margin-bottom: 1rem;">{{$invoice->payment_link}}</p>

    @if(!$deCustomer)
        <p>{{__('The invoice is shown without sales tax, since in this case the change of Tax liability (reverse charge procedure) applies. The service recipient must declare and pay the tax amount.')}}</p>
    @endif
    
    <p>{{__('For further inquiries, we are happy to help you.')}}</p> 
    <p style="margin-top: 2rem;">{{__('Your linoffery Team')}}</p>

@endsection