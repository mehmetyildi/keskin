@extends('layouts.app')

@section('seo')
    <!-- TITLE -->
    <title>{{ trans('local.news') }}</title>
    <meta property="og:title" content="{{ trans('local.news') }}"/>
    <meta name="keywords" content="{{ trans('keywords.home') }}">
    <!-- DESCRIPTION -->
    <meta name="description" content="{{ trans('local.seo') }}">
    <meta property="og:description" content="{{ trans('local.seo') }}"/>
    <!-- IMAGE -->
    <meta property="og:image" content="{{ asset('img/logo.png') }}"/>
    <!-- URL -->
    <meta property="og:url" content="{{ route('articles.index') }}"/>
    <meta name="canonical" content="{{ route('articles.index') }}"/>
@endsection

@section('content')
    <section class="module parallax parallax-articles">
        <div class="container full-height clearfix">
            <div class="row relative full-height">
                <div class="parallaxTitle">
                    {{ trans('local.news') }}
                </div>
            </div>
        </div>
    </section>
    @foreach($articles as $article)
    <section class="section80 {{ $loop->index % 2 == 0 ? 'greyBg' : ''}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <div class="imgWithBg clearfix mbXs">
                        <img src="{{ asset('storage/'.$article->main_image) }}" class="img-fluid" width="90%" alt="{{ $article->{'title_'.$l} }}" title="{{ $article->{'title_'.$l} }}">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <div class="homeNewsCard clearfix wow fadeIn" data-wow-delay="0.2s">
                        <span class="sep"></span>
                        <h3>{{ $article->{'title_'.$l} }}</h3>
                        <p>{{ $article->{'caption_'.$l} }} </p>
                        <div class="text-right">
                            <a href="{{ route('articles.detail', ['url' => $article->{'url_'.$l}]) }}" class="readMore">{{ trans('local.read-more') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endforeach
@endsection
