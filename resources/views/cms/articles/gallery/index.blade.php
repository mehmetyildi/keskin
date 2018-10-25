@extends('layouts.cms')
@section('title') <title>{{ config('app.cms_name') }} | Düzenle</title> @endsection
@section('styles')
	@include('cms.includes.form-partials.css-inserts')
@endsection
@section('content')

@component('cms.components.breadcrumb') 
	@slot('page') Galeri @endslot
	<li><a href="{{ route('cms.'.$pageUrl.'.index') }}">{{ $pageName }}</a></li>
	<li><a href="{{ route('cms.'.$pageUrl.'.edit', ['record' => $record->id]) }}">{{ $record->title_tr }}</a></li>
@endcomponent

<div class="wrapper wrapper-content animated fadeInRight">
   	<div class="row">
   		{!! Form::open(['route' => 'cms.'.$pageUrl.'.gallery.store', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
   			<input type="hidden" name="article_id" value="{{ $record->id }}">
		    <div class="col-lg-1 formActions">
		    	<a href="{{ route('cms.'.$pageUrl.'.edit', ['route' => $record->id]) }}" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i> Geri</a>
		    	<button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save"></i> Kaydet</button>
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
												<input type="checkbox" name="publish" class="js-switch js-switch1" />
											</div>
										</div>
				            		</div>
				            	</div>
				            </div>
				        </div>
		    		</div>
		    	</div>
		    </div>
	    {!! Form::close() !!}
	</div>
	<div class="row">
		<div class="col-lg-1 formActions"></div>
		<div class="col-lg-11">
			<div class="ibox float-e-margins">
	            <div class="ibox-title">
	                <h5>Galeri <small><i class="fa fa-hand-o-up"></i> Sürükle &amp; Bırak</small></h5>
	            </div>
            </div>
	    	<div class="row" id="sort-list">
	    		@foreach($record->images->sortBy('position') as $image)
	    		<div class="col-md-3" id="{{ $image->id }}">
                    <div class="ibox">
                        <div class="ibox-content product-box">
                            <a href="{{ url('storage/uncut_'.$image->main_image) }}" title="{{ $image->title_tr }}" data-gallery>
                            	<img src="{{ url('storage/'.$image->main_image) }}" class="img-responsive" alt="">
                        	</a>
                            <div class="product-desc">
                                <span class="product-price">
                                     Görseli büyümtek için üzerine tıklayın
                                </span>
                                <a href="{{ route('cms.'.$pageUrl.'.gallery.edit', ['record' => $image->id]) }}" class="product-name"> {{ ($image->title_tr) ?: 'Başlık Yok' }}</a>
                                <div class="small m-t-xs">
                                    {{ ($image->publish) ? 'Yayında' : 'Yayında Değil' }}
                                </div>
                                <div class="m-t text-righ">
                                    <a href="{{ route('cms.'.$pageUrl.'.gallery.edit', ['record' => $image->id]) }}" class="btn btn-xs btn-outline btn-primary"><i class="fa fa-edit"></i> Düzenle  </a>
                                    <a data-toggle="modal" data-target="#deleteModal{{$image->id}}" class="btn btn-xs btn-outline btn-danger"><i class="fa fa-trash"></i> Sil  </a>
                                    @include('cms.includes.delete-modal', [
										'modal_id' => 'deleteModal'.$image->id, 
										'route' => 'cms.'.$pageUrl.'.gallery.delete', 
										'id' => ['role' => $image->id]
									])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
	    	</div>
	    </div>
	</div>
</div>
<!-- The Gallery as lightbox dialog, should be a child element of the document body -->
<div id="blueimp-gallery" class="blueimp-gallery">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
@endsection

@section('scripts')
	@include('cms.includes.form-partials.js-inserts')
    <script src="{{ asset('cms/js/plugins/blueimp/jquery.blueimp-gallery.min.js') }}"></script>
	<script src="{{ url('cms/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
	<script>
		$(document).ready(function(){
            new Switchery(document.querySelector('.js-switch1'), { color: '#1AB394' });
            $("#sort-list").sortable({
		        update: function() {
		            var records = $( "#sort-list" ).sortable( "toArray" );
		            $.ajax({
		                data: { ids : window.JSON.stringify(records), _token: window.Laravel.csrfToken},
		                type: 'POST',
		                url: globalBaseUrl + '/{{ config("app.cms_path") }}/'+'{{ $pageUrl }}'+'/gallery/sort-records',
		                success: function() {
		                    toastr.success('Sıralama yapıldı');
		                }
		            });
		        }        
		    }).disableSelection();
        });
	</script>
@endsection