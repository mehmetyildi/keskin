@extends('layouts.cms')

@section('title') <title>{{ config('app.cms_name') }} | Yeni Kategori Oluştur</title> @endsection

@section('content')

@component('cms.components.breadcrumb') 
	@slot('page') Yeni Kategori Oluştur @endslot
	<li>
		<a href="{{ route('cms.forms.index') }}">Formlar</a>
	</li>
	<li>
		<a href="{{ route('cms.forms.edit', ['form' => $form->id]) }}">{{ $form->title }}</a>
	</li>
@endcomponent

<div class="wrapper wrapper-content animated fadeInRight">
   	<div class="row">
		{!! Form::open(['route' => 'cms.forms.categories.store', 'class' => 'form-horizontal']) !!}
		    <div class="col-lg-1 formActions">
		    	<a href="{{ route('cms.forms.edit', ['form' => $form->id]) }}" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i> Geri</a>
		    	<button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save"></i> Kaydet</button>
		    </div>
		    <div class="col-lg-11">
		        <div class="ibox float-e-margins">
		            <div class="ibox-title">
		                <h5>Yeni Kategori</h5>
		                <div class="ibox-tools">
		                    <a class="collapse-link">
		                        <i class="fa fa-chevron-up"></i>
		                    </a>
		                </div>
		            </div>
		            <div class="ibox-content">
		            	<div class="row">
		            		<div class="col-lg-6">
		            			<input type="hidden" name="contact_form_id" value="{{ $form->id }}">
		            			<div class="form-group">
			                    	<label class="col-sm-3 control-label">İlgili Form</label>
			                        <div class="col-sm-9">
			                        	{!! Form::text('related_form', $form->title, ['class' => 'form-control', 'readonly']) !!}
			                        	@if($errors->has('related_form'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('related_form') }}</strong>
					                        </span>
					                    @endif
			                    	</div>
			                    </div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Kategori Adı</label>
									<div class="col-sm-9">
										<ul class="nav nav-tabs">
											<li class="active"><a data-toggle="tab" href="#tab-title_tr"> TR</a></li>
											<li class=""><a data-toggle="tab" href="#tab-title_en">EN</a></li>
										</ul>
										<div class="tab-content">
											<div id="tab-title_tr" class="tab-pane active">
												{!! Form::text('title_tr', null, ['class' => 'form-control']) !!}
											</div>
											<div id="tab-title_en" class="tab-pane">
												{!! Form::text('title_en', null, ['class' => 'form-control']) !!}
											</div>
										</div>
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