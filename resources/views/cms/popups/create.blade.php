@extends('layouts.cms')
@section('title') <title>{{ config('app.cms_name') }} | Yeni {{ $pageItem }} Oluştur</title> @endsection
@section('styles')
	@include('cms.includes.form-partials.css-inserts')
@endsection
@section('content')

@component('cms.components.breadcrumb')
	@slot('page') Yeni {{ $pageItem }} Oluştur @endslot
	<li><a href="{{ route('cms.'.$pageUrl.'.index') }}">{{ $pageName }}</a></li>
@endcomponent

<div class="wrapper wrapper-content animated fadeInRight">
   	<div class="row">
	{!! Form::open(['route' => 'cms.'.$pageUrl.'.store', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
	    <div class="col-lg-1 formActions">
	    	<a href="{{ route('cms.'.$pageUrl.'.index') }}" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i> Geri</a>
	    	<button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save"></i> Kaydet</button>
	    </div>
	    <div class="col-lg-6">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><i class="fa fa-picture-o"></i> Görseller</h5>
					@include('cms.includes.form-partials.ibox-resize')
				</div>
				<div class="ibox-content">
					@include('cms.includes.crop-image-area', ['title' => 'Görsel (TR) (700x500)', 'field' => 'image_path_tr', 'ratio' => '1.4', 'required' => false])
					@include('cms.includes.crop-image-area', ['title' => 'Görsel (EN) (700x500)', 'field' => 'image_path_en', 'ratio' => '1.4', 'required' => false])
				</div>
			</div>
	        <div class="ibox float-e-margins">
	            <div class="ibox-title">
	                <h5><i class="fa fa-info-circle"></i> İçerik Bilgileri</h5>
					@include('cms.includes.form-partials.ibox-resize')
	            </div>
	            <div class="ibox-content">
					<div class="form-group">
						<label class="col-sm-3 control-label">Adı</label>
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
					<hr>
					<div class="form-group">
						<label class="col-sm-3 control-label">Video Linki</label>
						<div class="col-sm-9">
							{!! Form::text('video_path', null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<hr>
					<div class="form-group">
						<label class="col-sm-3 control-label">Link</label>
						<div class="col-sm-9">
							{!! Form::text('link', null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<hr>
					<div class="form-group">
						<label class="col-sm-3 control-label">Süre (sn.)</label>
						<div class="col-sm-9">
							{!! Form::number('duration', null, ['class' => 'form-control', 'step' => '1']) !!}
						</div>
					</div>
				</div>
	        </div>
	    </div>
		<div class="col-lg-5">
			@include('cms.includes.form-partials.create-publish-settings')
		</div>
    {!! Form::close() !!}
	</div>
</div>

@endsection

@section('scripts')
	@include('cms.includes.form-partials.js-inserts')
	<script>
        $(document).ready(function(){
            new Switchery(document.querySelector('.js-switch1'), { color: '#1AB394' });
            $('.input-group.date1').datepicker({
                todayHighlight: true,
                format: "dd/mm/yyyy",
                weekStart: 1,
                startDate: "{{ todayWithFormat('d/m/Y') }}"
            });
        });
	</script>
@endsection