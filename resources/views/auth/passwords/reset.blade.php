@extends('layouts.auth')

@section('title') <title>{{ config('app.cms_name') }} | Şifre Yenileme</title> @endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <h2 class="font-bold">Şifre Yenileme</h2>
        <p>
            Yeni şifrenizi belirleyerek sisteme giriş yapabilirsiniz.
        </p>

    </div>
    <div class="col-md-6">
        <div class="ibox-content">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form class="m-t" role="form" method="POST" action="{{ route('password.request') }}">
                {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" name="email" class="form-control" placeholder="E-Mail" required="" value="{{ $email or old('email') }}" autofocus>
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
                <button type="submit" class="btn btn-primary block full-width m-b">Şifremi Yenile</button>
            </form>
            <p class="m-t">
                <small>{{ config('app.cms_version') }}</small>
            </p>
        </div>
    </div>
</div>
@endsection