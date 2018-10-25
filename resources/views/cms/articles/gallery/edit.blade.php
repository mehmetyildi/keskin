@extends('layouts.cms')
@section('title') <title>{{ config('app.cms_name') }} | Düzenle</title> @endsection
@section('styles')
	@include('cms.includes.form-partials.css-inserts')
@endsection
@section('content')

@component('cms.components.breadcrumb') 
	@slot('page') Galeri @endslot
	<li><a href="{{ route('cms.'.$pageUrl.'.index') }}">{{ $pageName }}</a></li>
	<li><a href="{{ route('cms.'.$pageUrl.'.edit', ['record' => $record->article_id]) }}">{{ $record->article->title_tr }}</a></li>
@endcomponent

<div class="wrapper wrapper-content animated fadeInRight">
   	<div class="row">
   		{!! Form::model($record, ['route' => ['cms.'.$pageUrl.'.gallery.update', $record->id], 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
   			{!! method_field('PUT') !!}
   			<input type="hidden" name="article_id" value="{{ $record->article_id }}">
		    <div class="col-lg-1 formActions">
		    	<a href="{{ route('cms.'.$pageUrl.'.gallery', ['record' => $record->article_id]) }}" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i> Geri</a>
		    	<button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save"></i> Güncelle</button>
		    	<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i> Sil</button>
		    </div>
		    <div class="col-lg-11">
		    	<div class="row">
					<div class="col-md-6">
						<div class="ibox float-e-margins">
							<div class="ibox-title">
								<h5><i class="fa fa-picture-o"></i> Yeni Görsel</h5>
								@include('cms.includes.form-partials.ibox-resize')
							</div>
							<div class="ibox-content">
								<div class="row">
									<div class="col-lg-12">
										@include('cms.includes.crop-image-area', ['title' => 'Ana Görsel (1200x750)', 'field' => 'main_image', 'ratio' => '1.6', 'required' => false])
										<div class="form-group">
											<label class="col-sm-3 control-label">Başlık</label>
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
											<label class="col-sm-3 control-label" for="publish">Yayınla</label>
											<div class="col-sm-9">
												<input type="checkbox" name="publish" class="js-switch js-switch1" {{ $record->publish ? 'checked' : '' }}/>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
		    		<div class="col-md-5">
						<div class="ibox float-e-margins">
							<div class="ibox-title">
								<h5><i class="fa fa-upload"></i> Yüklenmiş Öğeler</h5>
								@include('cms.includes.form-partials.ibox-resize')
							</div>
							<div class="ibox-content clearfix">
								@if($record->main_image)
									<div class="form-group">
										<label class="control-label col-sm-3">Mevcut Ana Görsel</label>
										<div class="input-group col-sm-9">
											<img src="{{ url('storage/'.$record->main_image) }}" class="img-responsive" alt="">
										</div>
									</div>
								@endif
							</div>
						</div>
		    		</div>
		    	</div>
		    </div>
	    {!! Form::close() !!}
	</div>
</div>
@include('cms.includes.delete-modal', [
	'modal_id' => 'deleteModal', 
	'route' => 'cms.'.$pageUrl.'.gallery.delete',
	'id' => ['role' => $record->id]
])
@endsection

@section('scripts')
	@include('cms.includes.form-partials.js-inserts')
	<script>
		$(document).ready(function(){
            new Switchery(document.querySelector('.js-switch1'), { color: '#1AB394' });
        });
	</script>
@endsection