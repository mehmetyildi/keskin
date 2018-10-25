@extends('layouts.cms')

@section('title') <title>{{ config('app.cms_name') }} | Düzenle</title> @endsection

@section('content')

@component('cms.components.breadcrumb') 
	@slot('page') Düzenle @endslot
	<li>
		<a href="{{ route('cms.forms.index') }}">Formlar</a>
	</li>
@endcomponent

<div class="wrapper wrapper-content animated fadeInRight">
   	<div class="row">
	   	{!! Form::model($form, ['route' => ['cms.forms.update', $form->id], 'class' => 'form-horizontal']) !!}
	   		{!! method_field('PUT') !!}
		    <div class="col-lg-1 formActions">
		    	<a href="{{ route('cms.forms.index') }}" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i> Geri</a>
		    	<button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save"></i> Güncelle</button>
		    	@can('do_all')
		    	<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i> Sil</button>
		    	@endcan
		    </div>
		    <div class="col-lg-11">
		        <div class="ibox float-e-margins">
		            <div class="ibox-title">
		                <h5>Formu Düzenle <small>Bu forma alt kategoriler ve kullanıcılar ekleyebilirsiniz.</small></h5>
		                <div class="ibox-tools">
		                    <a class="collapse-link">
		                        <i class="fa fa-chevron-up"></i>
		                    </a>
		                </div>
		            </div>
		            <div class="ibox-content clearfix">
	                    <div class="col-lg-6">
	            			<div class="form-group">
		                    	<label class="col-sm-3 control-label">Form Adı</label>
		                        <div class="col-sm-9">
		                        	@can('create_form')
		                        	{!! Form::text('title', null, ['class' => 'form-control', 'required']) !!}
		                        	@else
		                        	{!! Form::text('title', null, ['class' => 'form-control', 'required', 'readonly']) !!}
		                        	@endcan
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
	    {!! Form::close() !!}
	</div>
	<div class="row">
		<div class="col-lg-11 col-lg-offset-1">
			<div class="ibox float-e-margins">
	            <div class="ibox-title">
	                <h5>Kategoriler</h5>
	                @can('create_form_category')
	                <div class="ibox-tools">
	                    <a href="{{ route('cms.forms.categories.create', ['form' => $form->id]) }}" class="btn btn-sm btn-primary clearfix">
	                    	<i class="fa fa-plus-circle"></i> Yeni Kategori Oluştur
                    	</a>
	                </div>
	                @endcan
	            </div>
	            <div class="ibox-content clearfix">
	            	<div class="table-responsive">
	            		<table class="table table-striped table-bordered table-hover categoriesTable" >
	            			<thead>
					            <tr>
					                <th>Adı</th>
					                <th>To</th>
					                <th>Cc</th>
					                <th>İşlem</th>
					            </tr>
	            			</thead>
	            			<tbody>
	            				@foreach($form->categories as $category)
					            <tr>
					                <td>{{ $category->title_tr }}</td>
					                <td>{{ $category->to }}</td>
					                <td>{{ $category->cc }}</td>
					                <td class="center actionsColumn">
					                	<a 	href="{{ route('cms.forms.categories.edit', ['category' => $category->id]) }}" 
					                		class="btn btn-sm btn-info">
					                		<i class="fa fa-edit"></i>
				                		</a>
					                	<button type="button" 
					                			class="btn btn-danger btn-sm" 
				                				data-toggle="modal" 
				                				data-target="#deleteModal{{ $category->id }}"><i class="fa fa-trash"></i>
		                				</button>
					                	@include('cms.includes.delete-modal', [ 
					                		'modal_id' => 'deleteModal'.$category->id, 
					                		'route' => 'cms.forms.categories.delete', 
					                		'id' => ['category' => $category->id]
			                			]) 
					                </td>
					            </tr>
					            @endforeach
	            			</tbody>
	            		</table>
	                </div>
	            </div>
            </div>
		</div>
	</div>
</div>
@can('do_all')
	<!-- Delete Modal -->
	@include('cms.includes.delete-modal', [
		'modal_id' => 'deleteModal', 
		'route' => 'cms.forms.delete', 
		'id' => ['form' => $form->id]
	])
	<!-- End Delete Modal -->
@endcan
@endsection

@section('scripts')
	<script>
        $(document).ready(function(){
        	initializeDatatable('.categoriesTable');
        });
    </script>
@endsection