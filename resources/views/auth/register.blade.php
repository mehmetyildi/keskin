@extends('layouts.auth')

@section('title') <title>{{ config('app.cms_name') }} | Yeni Hesap</title> @endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <h2 class="font-bold">Yeni Hesap Oluşturun</h2>

        <p>
            Web sitenizin içeriğini yönetebilmek hiç bu kadar kolay olmamıştı!
        </p>
        <p>
            Web siteniz özel olarak hazırladığımız yönetim panelinizden, sitenizdeki tüm değişiklikleri yapabilir, yeni içerik ekleyebilir, sitenize ait analitik sonuçları görebilirsiniz.
        </p>

        <p>
            <small>*Bu bölüme sadece yetkili kullanıcılar girebilir.</small>
        </p>
    </div>
    <div class="col-md-6">
        <div class="ibox-content">
            <form class="m-t" role="form" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                @if(isset($invitee))
                <input type="hidden" name="token" value="{{ $token }}">
                @endif
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <input {{ isset($invitee) ? 'readonly' : '' }} type="text" name="name" class="form-control" placeholder="Ad Soyad" required="" value="{{ $invitee->name or old('name') }}">
                    @if($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input {{ isset($invitee) ? 'readonly' : '' }} type="email" name="email" class="form-control" placeholder="E-Posta" required="" value="{{ $invitee->email or old('email') }}">
                    @if($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" name="password" class="form-control" placeholder="Şifre" required="">
                    @if($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password-confirm') ? ' has-error' : '' }}">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Şifre (Tekrar)" required="">
                    @if($errors->has('password-confirm'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password-confirm') }}</strong>
                        </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Kayıt Ol</button>

                <a href="{{ route('password.request') }}">
                    <small>Şifrenizi mi unuttunuz?</small>
                </a>

                <p class="text-muted text-center">
                    <small>Zaten hesabınız var mı?</small>
                </p>
                <a class="btn btn-sm btn-white btn-block" href="{{ route('login') }}">Giriş Yap</a>
            </form>
            <p class="m-t">
                <small>{{ config('app.cms_version') }}</small>
            </p>
        </div>
    </div>
</div>
@endsection

