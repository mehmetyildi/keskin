@extends('layouts.cms')

@section('title') <title>{{ config('app.cms_name') }} | Dosya Yöneticisi</title> @endsection

@section('styles')
	<link href="{{ asset('cms/css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet">
	<style>
		.clipper{
			cursor: pointer;
		}
	</style>
@endsection

@section('content')

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="file-manager">
                        <h5>DOSYA YÖNETİCİSİ</h5>
                        <a href="{{ route('cms.file-manager.index') }}" class="file-control active">Son Eklenenler</a>
                        <a class="file-control ">{{ $folder->title }}</a>
                        <div class="hr-line-dashed"></div>
                        <h5>KLASÖRLER</h5>
                        <ul class="folder-list" style="padding: 0">
                        	@foreach($folders as $fold)
                            <li><a href="{{ route('cms.file-manager.detail', ['folder' => $fold->id]) }}"><i class="fa {{ ($fold->id == $folder->id) ? 'fa-folder-open' : 'fa-folder' }}"></i> {{ $fold->title }}</a></li>
                            @endforeach
                        </ul>
                        <h5 class="tag-title">KLASÖR EKLE</h5>
                        {!! Form::open(['route' => 'cms.file-manager.categories.store', 'class' => 'form-horizontal']) !!}
                        <div class="form-group">
	                        <div class="col-sm-9">
	                        	{!! Form::text('title', null, ['class' => 'form-control', 'required', 'placeholder' => 'Klasör Adı']) !!}
	                        	@if($errors->has('title'))
			                        <span class="help-block">
			                            <strong>{{ $errors->first('title') }}</strong>
			                        </span>
			                    @endif
	                    	</div>
	                    	<button class="btn btn-primary col-sm-2" type="submit"><i class="fa fa-plus"></i></button>
	                    </div>
                        {!! Form::close() !!}
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 animated fadeInRight">
        	<div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="file-manager">
                        <h5>YENİ DOSYA</h5>
                        <a class="file-control ">"{{ $folder->title }}" klasörüne yeni bir dosya ekleyin.</a>
                        <div class="hr-line-dashed"></div>
                        {!! Form::open(['route' => 'cms.file-manager.store', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
                        <input type="hidden" name="file_manager_category_id" value="{{ $folder->id }}">
                        <div class="form-group">
	                    	<label class="col-sm-2 control-label">Dosya Adı</label>
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
                        	<label class="col-sm-2 control-label">Yükelenecek Dosya</label>
	                    	<div class="col-sm-9">
			                    <div class="fileinput fileinput-new input-group col-sm-12" data-provides="fileinput">
	                                <div class="form-control" data-trigger="fileinput">
	                                	<i class="glyphicon glyphicon-file fileinput-exists"></i> 
	                                	<span class="fileinput-filename"></span>
                                	</div>
	                                <span class="input-group-addon btn btn-default btn-file">
	                                	<span class="fileinput-new">Dosya Seç</span>
	                                	<span class="fileinput-exists">Değiştir</span>
	                                	<input type="file" name="file_path">
                                	</span>
	                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Kaldır</a>
                            	</div>
                            </div>
                        </div>
                        <div class="form-group">
                        	<label class="col-sm-2 control-label"></label>
                        	<div class="col-sm-9">
                        	<button type="submit" class="btn btn-primary col-sm-1"><i class="fa fa-upload"></i> Yükle</button>
                        	</div>
                        </div>
                       
                        {!! Form::close() !!}
                        <div class="hr-line-dashed"></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                	@foreach($records as $record)
                    <div class="file-box">
                        <div class="file">
                            <span class="corner"></span>
                        	<a href="{{ url('storage/file-manager/'.$record->file_path) }}" target="_blank">
	                            <div class="icon">
	                            	@if(substr($record->file_path, -3) == 'jpg' or substr($record->file_path, -3) == 'png')
	                            	<img alt="image" class="img-responsive" src="{{ url('storage/file-manager/'.$record->file_path) }}">
	                            	@else
	                                <i class="fa fa-file"></i>
	                                @endif
	                            </div>
                        	</a>
                            <div class="file-name">
                            	{{ $record->category->title }} <br/>
                                <small>
                                	<span data-clipboard-text="{{ url('storage/file-manager/'.$record->file_path) }}" class="clipper"><i class="fa fa-clipboard"></i> Linki Kopyala</span> 
                            	</small>
                                <br/>
                                <small>Eklendi: {{ $record->created_at->format('d-m-Y') }}</small>
                                <br/>
                                <a class="text-danger" 
									data-toggle="modal" 
									data-target="#deleteModal{{ $record->id }}">Sil
								</a>
                            </div>
                        </div>
                    </div>
					
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@foreach($records as $record)
	@include('cms.includes.delete-modal', [ 
		'modal_id' => 'deleteModal'.$record->id, 
		'route' => 'cms.file-manager.delete', 
		'id' => ['file' => $record->id]
	]) 
@endforeach
@endsection
@section('scripts')

    <script src="{{ asset('cms/js/plugins/jcrop/js/bootstrap-fileinput.js') }}"></script>
    <!-- Switchery -->
    <script src="https://cdn.jsdelivr.net/clipboard.js/1.6.0/clipboard.min.js"></script>
    <script>
        $(document).ready(function(){
        	var clipboard = new Clipboard('.clipper');
			clipboard.on('success', function(e) {
			    toastr.success("Kopyalandı!");
			});
        });
    </script>
@endsection