@extends('layouts.cms')

@section('title') <title>{{ config('app.cms_name') }} | Arama Sonuçları</title> @endsection

@section('content')

@component('cms.components.breadcrumb') 
	@slot('page') Arama @endslot
@endcomponent

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <h2>
                        <span class="text-navy">“{{$keyword}}”</span> için {{ $results->count() }} sonuç bulundu
                    </h2>

                    <div class="search-form">
                        <form role="search" action="{{ route('cms.search') }}">
                            <div class="input-group">
                                <input type="text" placeholder="Başka bir şey arayın..." name="keyword" class="form-control input-lg" autocomplete="off">
                                <div class="input-group-btn">
                                    <button class="btn btn-lg btn-primary" type="submit">
                                        Ara
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="hr-line-dashed"></div>
                    @if($results->count())
	                    @foreach($results as $result)
	                    <div class="search-result">
	                        <h3><a href="{{ url('cms/'.$result->folder.'/'.$result->key.'/edit') }}">{{ $result->keyword }} <small>({{$result->folder}})</small></a></h3>
	                        <a href="{{ url('cms/'.$result->folder.'/'.$result->key.'/edit') }}" class="search-link">{{ url('cms/'.$result->folder.'/'.$result->key.'/edit') }}</a>
	                        
	                    </div>
	                    <div class="hr-line-dashed"></div>
	                    @endforeach
                    @else
                    	<h4>Herhangi bir sonuç bulunamadı.</h4>
                    	<div class="hr-line-dashed"></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection