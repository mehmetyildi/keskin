@component('mail::message')
# Merhaba {{ $name }}

Bu e-postayı Piyetra CMS'e davet edildiğiniz için aldınız.

@component('mail::button', ['url' => url('/register?token='.$token)])
Hesabınızı Oluşturun
@endcomponent

İyi günler,<br>
Piyetra


@component('mail::subcopy')
"Hesabınızı Oluşturun" butonuna basmak ile ilgili sorun yaşıyorsanız, aşağıdaki URL'i kopyalayıp web tarayıcınıza yapıştırabilirsiniz:
<br> [{{ url('/register?token='.$token) }}]({{ url('/register?token='.$token) }})
@endcomponent

@endcomponent