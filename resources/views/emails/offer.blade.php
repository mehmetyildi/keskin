@component('mail::message')
# {{ $name }} size bir teklif talebi gönderdi
Firma: {{ $company }} <br>
Şehir: {{ $city }} <br>
Malzeme Cinsi: {{ $materialType }} <br>
Malzeme Et Kalınlığı: {{ $thickness }} <br>
Malzeme Ölçüleri: {{ $sizes }} <br>
Toplam Ağırlık: {{ $weight }} <br>

{!! $body !!}

{{ $name }} <br>
<hr>
Email: {{ $email }} <br>
Telefon: {{ $phone }} <br>

@endcomponent