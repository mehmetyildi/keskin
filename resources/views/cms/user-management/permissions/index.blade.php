@extends('layouts.cms')

@section('title') <title>{{ config('app.cms_name') }} | Yetkiler</title> @endsection

@section('content')

@component('cms.components.breadcrumb') 
	@slot('page') Yetkiler @endslot
@endcomponent

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title">
            		<a href="{{ route('cms.user-management.permissions.create') }}" class="btn btn-sm btn-primary clearfix" ><i class="fa fa-plus-circle"></i> Yeni Yetki Oluştur</a>
	            </div>
	            <div class="ibox-content">

	                <div class="table-responsive">
	            		<table class="table table-striped table-bordered table-hover dataTable" >
	            			<thead>
					            <tr>
					                <th>Yetki Adı</th>
					                <th>İşlem</th>
					            </tr>
	            			</thead>
	            			<tbody>
	            				@foreach($permissions as $permission)
					            <tr>
					                <td>{{ $permission->name }}</td>
					                <td class="center actionsColumn tooltip-demo">
					                	@if($permission->id != 1)
						                	<a 	href="{{ route('cms.user-management.permissions.edit', ['permission' => $permission->id]) }}" 
						                		class="btn btn-sm btn-info">
						                		<i class="fa fa-edit"></i>
					                		</a>
					                		<button type="button" 
						                			class="btn btn-danger btn-sm" 
					                				data-toggle="modal" 
					                				data-target="#deleteModal{{ $permission->id }}"><i class="fa fa-trash"></i>
			                				</button>
						                	@include('cms.includes.delete-modal', [ 
						                		'modal_id' => 'deleteModal'.$permission->id, 
						                		'route' => 'cms.user-management.permissions.delete', 
						                		'id' => ['permission' => $permission->id]
				                			]) 
					                	@else
					                		<button disabled class="btn btn-sm btn-warning">n / a</a>
					                	@endif
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

@endsection

@section('scripts')
	<script>
        $(document).ready(function(){
           initializeDatatable('.dataTable');
        });
    </script>
@endsection