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

					@include('cms.includes.crop-image-area', ['title' => 'Görsel', 'field' => 'main_image', 'ratio' => '1.4', 'required' => false])
					<div class="error col-md-offset-3" style="color: red;">{{ $errors->first('main_image') }}</div>
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
							<div class="error" style="color: red;">{{ $errors->first('title_tr') }}</div>
						</div>
					</div>
					
					<hr>
					<div class="form-group">
						<label class="col-sm-3 control-label">Yazı</label>
						<div class="col-sm-9">
							<ul class="nav nav-tabs">
								<li class="active"><a data-toggle="tab" href="#tab-caption_tr"> TR</a></li>
								<li class=""><a data-toggle="tab" href="#tab-caption_en">EN</a></li>
							</ul>
							<div class="tab-content">
								<div id="tab-caption_tr" class="tab-pane active">
									{!! Form::textarea('description_tr', null, ['class' => 'form-control', 'rows' => '3']) !!}
								</div>
								<div id="tab-caption_en" class="tab-pane">
									{!! Form::textarea('description_en', null, ['class' => 'form-control', 'rows' => '3']) !!}
								</div>
							</div>
							<div class="error" style="color: red;">{{ $errors->first('description_tr') }}</div>
						</div>
					</div>
					
					<hr>
					<div class="form-group">
						<label class="col-sm-3 control-label">Video Linki</label>
						<div class="col-sm-9">
							{!! Form::text('video_path', null, ['class' => 'form-control']) !!}
							<div class="error" style="color: red;">{{ $errors->first('video_path') }}</div>
						</div>
					</div>
					

					<div class="form-group">
						<label class="col-sm-3 control-label">Ürünler</label>
						<div class="col-sm-9">
							{{ Form::select('product_list[]', $products,null, ['id'=>'tag_list', 'class' => 'form-control', 'multiple','style'=>'display:none;width:100%;','tabindex'=>'-1']) }}
						</div>
					</div>
					
				</div>
			</div>
		</div>
		<div class="col-lg-5">
			
			@include('cms.includes.form-partials.create-publish-settings-no-publish-date')
		</div>
		
		{!! Form::close() !!}
	</div>
</div>

@endsection

@section('scripts')
@include('cms.includes.form-partials.js-inserts')
<script>
	$(document).ready(function(){
		

		$("#tag_list").select2({placeholder:'İlgili Ürünleri Seçiniz'});
		new Switchery(document.querySelector('.js-switch1'), { color: '#1AB394' });
		new Switchery(document.querySelector('.js-switch2'), { color: '#1AB394' });
		$('.input-group.date1').datepicker({
			todayHighlight: true,
			format: "dd/mm/yyyy",
			weekStart: 1,
			startDate: "{{ todayWithFormat('d/m/Y') }}"
		});
		$('.input-group.date2').datepicker({
			todayHighlight: true,
			format: "dd/mm/yyyy",
			weekStart: 1
		});
	});
</script>
@endsection