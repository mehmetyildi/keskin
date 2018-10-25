@extends('layouts.cms')

@section('title') <title>{{ config('app.cms_name') }} | Yeni Form Oluştur</title> @endsection

@section('content')

@component('cms.components.breadcrumb') 
	@slot('page') Yeni Form Oluştur @endslot
	<li>
		<a href="{{ route('cms.forms.index') }}">Formlar</a>
	</li>
@endcomponent

<div class="wrapper wrapper-content animated fadeInRight">
   	<div class="row">
		{!! Form::open(['route' => 'cms.forms.store', 'class' => 'form-horizontal']) !!}
		    <div class="col-lg-1 formActions">
		    	<a href="{{ route('cms.forms.index') }}" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i> Geri</a>
		    	<button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save"></i> Kaydet</button>
		    </div>
		    <div class="col-lg-11">
		        <div class="ibox float-e-margins">
		            <div class="ibox-title">
		                <h5>Yeni Form <small>Bir form oluşturduktan sonra yeni kategoriler ekleyebilirsiniz.</small></h5>
		                <div class="ibox-tools">
		                    <a class="collapse-link">
		                        <i class="fa fa-chevron-up"></i>
		                    </a>
		                </div>
		            </div>
		            <div class="ibox-content">
		            	<div class="row">
		            		<div class="col-lg-6">
		            			<div class="form-group">
			                    	<label class="col-sm-3 control-label">Form Adı</label>
			                        <div class="col-sm-9">
			                        	{!! Form::text('title', null, ['class' => 'form-control', 'required']) !!}
			                        	@if($errors->has('title'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('title') }}</strong>
					                        </span>
					                    @endif
			                    	</div>
			                    </div>
			                    <div class="form-group">
			                    	<label class="col-sm-3 control-label">Alıcı (To)</label>
			                        <div class="col-sm-9">
			                        	{!! Form::text('to', null, ['class' => 'form-control', 'required']) !!}
			                        	@if($errors->has('to'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('to') }}</strong>
					                        </span>
					                    @endif
			                    	</div>
			                    </div>
			                    <div class="form-group">
			                    	<label class="col-sm-3 control-label">Alıcı (Cc)</label>
			                        <div class="col-sm-9">
			                        	{!! Form::text('cc', null, ['class' => 'form-control']) !!}
			                        	@if($errors->has('cc'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('cc') }}</strong>
					                        </span>
					                    @endif
			                    	</div>
			                    </div>
		            		</div>
		            	</div>
		            </div>
		        </div>
		    </div>
	    {!! Form::close() !!}
	</div>
</div>

@endsection