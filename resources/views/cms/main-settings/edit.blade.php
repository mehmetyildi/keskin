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
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5><i class="fa fa-upload"></i> Yüklenmiş Öğeler</h5>
						@include('cms.includes.form-partials.ibox-resize')
					</div>
					<div class="ibox-content">
						@if(strpos($record->opening_video, 'https://www.youtube.com/embed/') !== false || strpos($record->opening_video, 'https://player.vimeo.com/') !== false)
							<div class="form-group">
								<label class="control-label col-sm-3">Mevcut Açılış Videosu</label>
								<div class="input-group col-sm-9">
									<div class="controls embed-responsive embed-responsive-16by9" >
										<iframe class="embed-responsive-item" src="{{ $record->opening_video }}" style="width:100%;"></iframe>
									</div>
									<small>*Videoyu silmek için "Video Linki" alanındaki linki silip, kaydı güncelleyin.</small>
								</div>
							</div>

						@else
							Yüklenmiş Bir Video Yok
						@endif
						<hr>
						@if(strpos($record->opening_video_mobile, 'https://www.youtube.com/embed/') !== false || strpos($record->opening_video_mobile, 'https://player.vimeo.com/') !== false)
							<div class="form-group">
								<label class="control-label col-sm-3">Mevcut Açılış Videosu</label>
								<div class="input-group col-sm-9">
									<div class="controls embed-responsive embed-responsive-16by9" >
										<iframe class="embed-responsive-item" src="{{ $record->opening_video_mobile }}" style="width:100%;"></iframe>
									</div>
									<small>*Videoyu silmek için "Video Linki" alanındaki linki silip, kaydı güncelleyin.</small>
								</div>
							</div>

						@else
							Yüklenmiş Bir Video Yok
						@endif
						<hr>
						@if(strpos($record->corporate_video, 'https://www.youtube.com/embed/') !== false || strpos($record->corporate_video, 'https://player.vimeo.com/') !== false)
							<div class="form-group">
								<label class="control-label col-sm-3">Mevcut Kurumsal Video</label>
								<div class="input-group col-sm-9">
									<div class="controls embed-responsive embed-responsive-16by9" >
										<iframe class="embed-responsive-item" src="{{ $record->corporate_video }}" style="width:100%;"></iframe>
									</div>
									<small>*Videoyu silmek için "Video Linki" alanındaki linki silip, kaydı güncelleyin.</small>
								</div>
							</div>

						@else
							Yüklenmiş Bir Video Yok
						@endif
						<hr>
						@if($record->news_image)
							<div class="form-group">
								<label class="control-label col-sm-3">
									Mevcut görsel <br><br>
									<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteNewsImage"><i class="fa fa-trash"></i> Sil</button>
								</label>
								<div class="input-group col-sm-9">
									<img src="{{ url('storage/'.$record->news_image) }}" class="img-responsive" alt="">
								</div>
							</div>
						@else
							Yüklenmiş bir görsel yok.
						@endif
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</div>

<!-- Delete Object Modal -->
@include('cms.includes.delete-object-modal', [
    'modal_id' => 'deleteNewsImage',
    'field' => 'news_image',
    'route' => 'cms.'.$pageUrl.'.delete-file',
    'id' => ['record' => $record->id]
])
<!-- End Delete Object Modal -->

<!-- Delete Modal -->
@include('cms.includes.delete-modal', [
	'modal_id' => 'deleteModal',
	'route' => 'cms.'.$pageUrl.'.delete',
	'id' => ['role' => $record->id]
])
<!-- End Delete Modal -->
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