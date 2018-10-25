@extends('layouts.cms')
@section('title') <title>{{ config('app.cms_name') }} | Düzenle</title> @endsection
@section('styles')
	@include('cms.includes.form-partials.css-inserts')
@endsection
@section('content')

@component('cms.components.breadcrumb')
	@slot('page') Düzenle @endslot
	<li><a href="{{ route('cms.'.$pageUrl.'.index') }}">{{ $pageName }}</a></li>
@endcomponent

<div class="wrapper wrapper-content animated fadeInRight">
   	<div class="row">
	   	{!! Form::model($record, ['route' => ['cms.'.$pageUrl.'.update', $record->id], 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
	   		{!! method_field('PUT') !!}
		    <div class="col-lg-1 formActions">
		    	<a href="{{ route('cms.'.$pageUrl.'.index') }}" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i> Geri</a>
		    	@can('edit_content')
		    	<button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save"></i> Güncelle</button>
		    	@endcan
		    	
		    </div>
			<div class="col-lg-6">
				
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
							<label class="col-sm-3 control-label">Ana Video Linki</label>
							<div class="col-sm-9">
								{!! Form::text('main_video_path', null, ['class' => 'form-control']) !!}
							</div>
						</div>
						<hr>
						<div class="form-group">
							<label class="col-sm-3 control-label">Mobil Video Linki</label>
							<div class="col-sm-9">
								{!! Form::text('mobile_video_path', null, ['class' => 'form-control']) !!}
							</div>
						</div>
						
					</div>
				</div>
			</div>
			<div class="col-lg-5">
				
					<div class="ibox-title">
						<h5><i class="fa fa-upload"></i> Yüklenmiş Öğeler</h5>
						@include('cms.includes.form-partials.ibox-resize')
					</div>
					<div class="ibox-content">
						
						@if(strpos($record->main_video_path, 'https://www.youtube.com/embed/') !== false || strpos($record->video_path, 'https://player.vimeo.com/') !== false)
							<div class="form-group">
								<label class="control-label col-sm-3">Mevcut Video</label>
								<div class="input-group col-sm-9">
									<div class="controls embed-responsive embed-responsive-16by9" >
										<iframe class="embed-responsive-item" src="{{ $record->main_video_path }}" style="width:100%;"></iframe>
									</div>
									<small>*Videoyu silmek için "Video Linki" alanındaki linki silip, kaydı güncelleyin.</small>
								</div>
							</div>

						@else
							Yüklenmiş Bir Video Yok
						@endif
					</div>
				</div>
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