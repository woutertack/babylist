@component('mail::message')
{{__('Thank you for your order on Babylist!')}}



@component('mail::button', ['url' => ''])
{{__('Your total order payment')}}: €{{ $order->total}}

@endcomponent

Thanks, Babylist

@endcomponent
