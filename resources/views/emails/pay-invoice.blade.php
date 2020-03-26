@component('mail::message')
# @lang('Thank you for using our platform.')

<p>{{__('As agreed, we will invoice the following service.')}}</p>

@component('mail::table')
<table style="width:100%; margin-top: 2rem; margin-bottom: 2rem">
    <thead>
        <tr>            
            <th>{{__('Loading Nr.')}}</th>
            <th>{{__('Mediation Nr.')}}</th>
            <th style="text-align: right">{{__('Price in EUR')}}</th>
        </tr>
    </thead>
    <tbody>
        <tr style="text-align: center">            
            <td>{{$invoice->order->tender->custom_id}}</td>
            <td>{{$invoice->order->custom_id}}</td>
            <td style="text-align: right">{{$invoice->order->offer->price}} EUR</td>
        </tr>

        <tr style="text-align: right">
            <td colspan="2">{{__('Amount of the agency fee incurred')}}</td>
            <td>{{config('linoffery.payment.standard')}} %</td>
        </tr>
        <tr style="text-align: right">
            <td colspan="2">{{__('Net amount')}}</td>
            <td>{{ number_format($invoice->order->cost , 2, ',', ' ') }} EUR</td>        
        </tr>
        <tr style="text-align: right">
            <td colspan="2">{{__('VAT')}}</td>
            @if($invoice->company->deLocated)
                <td>19 %</td>
            @else
                <td>{{__('Reverse charge procedure')}}</td>
            @endif      
        </tr>
        <tr style="font-weight:bold; text-align: right">
            <td colspan="2">{{__('Invoice amount')}}</td>
            @if ($invoice->company->deLocated)
                <td>{{ number_format($invoice->order->cost*1.19 , 2, ',', ' ')}} EUR</td>
            @else
                <td>{{ number_format($invoice->order->cost , 2, ',', ' ') }} EUR</td>
            @endif        
        </tr>
    </tbody>  
</table>    
@endcomponent

<p>
    <span>{{__('The invoice has to be paid immediately.')}}</span>
    <span>{{__('Please use our payment options at this link:')}}</span>
</p>

@component('mail::button', ['url' => url($invoice->payment_link)])
    @lang('Pay now')
@endcomponent

<small>{{__('If you cannot use the button, try this link.')}}</small>
<small>{{url($invoice->payment_link)}}</small>

<p>{{__('For further inquiries, we are happy to help you.')}}</p> 
<p style="margin-top: 2rem;">{{__('Your linoffery Team')}}</p>

@endcomponent