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
					@include('cms.includes.crop-image-area', ['title' => 'Görsel (800x1200)', 'field' => 'news_image', 'ratio' => '0.66', 'required' => false])
				</div>
			</div>
			<div class="ibox float-e-margins">
	            <div class="ibox-title">
	                <h5><i class="fa fa-info-circle"></i> İçerik Bilgileri</h5>
					@include('cms.includes.form-partials.ibox-resize')
	            </div>
	            <div class="ibox-content">
					<div class="form-group">
						<label class="col-sm-3 control-label">Açılış Videosu Linki</label>
						<div class="col-sm-9">
							{!! Form::text('opening_video', null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<hr>
					<div class="form-group">
						<label class="col-sm-3 control-label">Açılış Videosu Linki (Mobil)</label>
						<div class="col-sm-9">
							{!! Form::text('opening_video_mobile', null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<hr>
					<div class="form-group">
						<label class="col-sm-3 control-label">Kurumsal Video Linki</label>
						<div class="col-sm-9">
							{!! Form::text('corporate_video', null, ['class' => 'form-control']) !!}
						</div>
					</div>
				</div>
	        </div>
	    </div>
		<div class="col-lg-5">
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