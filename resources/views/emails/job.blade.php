@component('mail::message')
# {{ $name }}
Pozisyon: {{ $position }} <br>

{!! $body !!}

{{ $name }} <br>
<hr>
Telefon: {{ $phone }} <br>
Email: {{ $email }}

@endcomponent