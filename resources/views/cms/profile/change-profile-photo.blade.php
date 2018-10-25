@extends('layouts.cms')

@section('title') <title>{{ config('app.cms_name') }} | Profil Fotoğrafı</title> @endsection

@section('styles')
	@include('cms.includes.form-partials.css-inserts')
@endsection

@section('content')

@component('cms.components.breadcrumb') 
	@slot('page') Profil Fotoğrafınızı Değiştirin @endslot
@endcomponent

<div class="wrapper wrapper-content animated fadeInRight">
   	<div class="row">
	{!! Form::open(['route' => 'cms.change-profile-photo.store', 'class' => 'form-horizontal', 'novalidate', 'enctype' => 'multipart/form-data']) !!}
	    <div class="col-lg-1 formActions">
	    	<a href="{{ route('cms.home') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Geri</a>
	    	<button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Kaydet</button>
	    </div>
	    <div class="col-lg-11">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title">
	                <h5>Yeni profil fotoğrafınızı kırpın ve yükleyin<small></small></h5>
	                <div class="ibox-tools">
	                    <a class="collapse-link">
	                        <i class="fa fa-chevron-up"></i>
	                    </a>
	                </div>
	            </div>
	            <div class="ibox-content">
	            	<div class="row">
	            		<div class="col-lg-9">
	            			@include('cms.includes.crop-image-area', ['title' => ' Profil Fotoğrafı', 'field' => 'theFile', 'ratio' => '1', 'required' => false])
	            		</div>
	            	</div>
	            </div>
	        </div>
	    </div>
    {!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')
	@include('cms.includes.form-partials.js-inserts')
@endsection