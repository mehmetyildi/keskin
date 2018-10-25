@extends('layouts.cms')

@section('title') <title>{{ config('app.cms_name') }} | Düzenle</title> @endsection

@section('content')

@component('cms.components.breadcrumb') 
	@slot('page') Düzenle @endslot
	<li>
		<a href="{{ route('cms.user-management.roles.index') }}">Roller</a>
	</li>
@endcomponent

<div class="wrapper wrapper-content animated fadeInRight">
   	<div class="row">
   	{!! Form::model($role, ['route' => ['cms.user-management.roles.update', $role->id], 'class' => 'form-horizontal']) !!}
   		{!! method_field('PUT') !!}
	    <div class="col-lg-1 formActions">
	    	<a href="{{ route('cms.user-management.roles.index') }}" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i> Geri</a>
	    	<button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save"></i> Güncelle</button>
	    	<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i> Sil</button>
	    </div>
	    <div class="col-lg-11">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title">
	                <h5>Rolü Düzenle <small>Bu role yeni yetkiler tanımlayabilirsiniz.</small></h5>
	                <div class="ibox-tools">
	                    <a class="collapse-link">
	                        <i class="fa fa-chevron-up"></i>
	                    </a>
	                </div>
	            </div>
	            <div class="ibox-content clearfix">
                    <div class="col-lg-6">
            			<div class="form-group">
	                    	<label class="col-sm-3 control-label">Rol Adı</label>
	                        <div class="col-sm-9">
	                        	{!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
	                        	@if($errors->has('name'))
			                        <span class="help-block">
			                            <strong>{{ $errors->first('name') }}</strong>
			                        </span>
			                    @endif
	                    	</div>
	                    </div>
	                    <div class="form-group">
                            <label for="title" class="col-sm-3 control-label">Yetkiler</label>
                            <div class="col-sm-9">
                                {{ Form::select('permission_list[]', $permissions, $role->permissionList, ['id' => 'permission_list', 'class' => 'form-control', 'multiple', 'style' => 'display: none; width: 100%;', 'tabindex' => '-1']) }}
                            </div>  
                        </div>
            		</div>
	            </div>
	        </div>
	    </div>
    {!! Form::close() !!}
	</div>
</div>

<!-- Delete Modal -->
@include('cms.includes.delete-modal', [
	'modal_id' => 'deleteModal', 
	'route' => 'cms.user-management.roles.delete', 
	'id' => ['role' => $role->id]
])
<!-- End Delete Modal -->

@endsection

@section('scripts')
	<script>
		 $("#permission_list").select2();
	</script>
@endsection