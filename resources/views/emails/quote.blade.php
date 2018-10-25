@component('mail::message')
# {{ $name }}  Size bir teklif talebi gönderdi

{!! $body !!}

{{ $name }} <br>
<hr>
Firma: {{ $company }} <br>
Ürün: {{ $product }} <br>
Telefon: {{ $phone }} <br>
Email: {{ $email }} <br>

@endcomponent