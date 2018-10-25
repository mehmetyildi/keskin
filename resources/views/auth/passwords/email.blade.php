@extends('layouts.auth')

@section('title') <title>{{ config('app.cms_name') }} | Şifre Yenileme</title> @endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <h2 class="font-bold">Şifre Yenileme</h2>

        <p>
            Lütfen sistemde kayıtlı e-posta adresinizi yazın. Size göndereceğimiz e-posta'daki adımları takip ederek şifrenizi yenileyebilirsiniz.
        </p>

    </div>
    <div class="col-md-6">
        <div class="ibox-content">
            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form class="m-t" role="form" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" name="email" class="form-control" placeholder="E-Posta" required="">
                    @if($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Şifre Yenileme Linkini Gönder</button>

                <p class="text-muted text-center">
                    <small>Şifrenizi hatırladınız mı?</small>
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