@extends('layouts.app')

@section('seo')
    <!-- TITLE -->
    <title>{{ $theArticle->{'title_'.$l} }}</title>
    <meta property="og:title" content="{{ $theArticle->{'title_'.$l} }}"/>
    <meta name="keywords" content="{{ trans('keywords.home') }}">
    <!-- DESCRIPTION -->
    <meta name="description" content="{{ $theArticle->{'caption_'.$l} }}">
    <meta property="og:description" content="{{ $theArticle->{'caption_'.$l} }}"/>
    <!-- IMAGE -->
    <meta property="og:image" content="{{ asset('storage/'.$theArticle->main_image) }}"/>
    <!-- URL -->
    <meta property="og:url" content="{{ route('articles.detail', ['url' => $theArticle->{'url_'.$l}]) }}"/>
    <meta name="canonical" content="{{ route('articles.detail', ['url' => $theArticle->{'url_'.$l}]) }}"/>
@endsection

@section ('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-flat.css" />
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
    <section class="section120">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-12">
                    <article class="clearfix">
                        <div class="newsDetailImage">
                            <img src="{{ asset('storage/'.$theArticle->main_image) }}" class="img-fluid fullWidth" alt="{{ $theArticle->{'title_'.$l} }}" title="{{ $theArticle->{'title_'.$l} }}">
                        </div>
                        <h1 class="headingLeft">{{ $theArticle->{'title_'.$l} }}</h1>
                        {!! $theArticle->{'description_'.$l} !!}
                    </article>
                </div>
            </div>
            @if($theArticle->video_path)
                <div class="row mb-5">
                    <div class="col-lg-10 offset-lg-1 col-md-12 col-sm-12 col-xs-12">
                        <div class="videoContainer clearfix">
                            <div class="videoBox">
                                <div class="controls embed-responsive embed-responsive-16by9" >
                                    <iframe class="embed-responsive-item" src="{{ $theArticle->video_path }}" style="width:100%;"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row mb-5">
                <div class="col">
                    <br>
                    <div class="shareArea clearfix ">
                        <div id="shareSocial"></div>
                    </div>
                </div>
            </div>
            @if($theArticle->images->count())
            <div class="row mb-5">
                @foreach($theArticle->images->where('publish', true)->sortBy('position') as $image)
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 mb-4">
                    <a data-fancybox="gallery" href="{{ asset('storage/uncut_'.$image->main_image) }}">
                        <img src="{{ asset('storage/'.$image->main_image) }}" class="img-fluid fullWidth" alt="{{ $image->{'title_'.$l} }}" title="{{ $image->{'title_'.$l} }}">
                    </a>
                </div>
                @endforeach
            </div>
            @endif
            <div class="row mb-5">
                <div class="col-12 mb-5">
                    <div class="divider clearfix"></div>
                </div>
                @foreach($articles as $article)
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 mb-4">
                    <div class="articleNewsCard clearfix wow fadeIn" data-wow-delay="0.2s">
                        <div class="mainPart">
                            <h3>{{ $article->{'title_'.$l} }}</h3>
                            <p>{{ $article->{'caption_'.$l} }} </p>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('articles.detail', ['url' => $article->{'url_'.$l}]) }}" class="readMore">{{ trans('local.read-more') }}</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.min.js"></script>
    <script>
        jQuery("#shareSocial").jsSocials({
            shareIn: "popup",
            showLabel: false,
            showCount: false,
            shares: ["email", "twitter", "facebook", "googleplus", "linkedin", "pinterest"]
        });
    </script>
@endsection