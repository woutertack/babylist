@component('mail::message')
# Thanky you for your order on Babylist!



@component('mail::button', ['url' => ''])
Your total order payment: €{{ $order->total}}

@endcomponent

Thanks, Babylist

@endcomponent
