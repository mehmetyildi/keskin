@extends('layouts.auth')

@section('title') <title>{{ config('app.cms_name') }} | Giriş Yap</title> @endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <h2 class="font-bold">{{ config('app.cms_name') }}'e Hoşgeldiniz</h2>
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
            <form class="m-t" role="form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" name="email" class="form-control" placeholder="E-Posta" required="">
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
                <button type="submit" class="btn btn-primary block full-width m-b">Giriş Yap</button>

                <a href="{{ route('password.request') }}">
                    <small>Şifrenizi mi unuttunuz?</small>
                </a>
                @if(!$userCount)
                <p class="text-muted text-center">
                    <small>Hesabınız yok mu?</small>
                </p>
                <a class="btn btn-sm btn-white btn-block" href="{{ route('register') }}">Yeni Hesap Aç</a>
                @endif
            </form>
            <p class="m-t">
                <small>{{ config('app.cms_version') }}</small>
            </p>
        </div>
    </div>
</div>
@endsection
