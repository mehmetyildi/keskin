@extends('layouts.cms')

@section('title') <title>{{ config('app.cms_name') }} | Roller</title> @endsection

@section('content')

@component('cms.components.breadcrumb') 
	@slot('page') Roller @endslot
@endcomponent

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title">
            		<a href="{{ route('cms.user-management.roles.create') }}" class="btn btn-sm btn-primary clearfix" ><i class="fa fa-plus-circle"></i> Yeni Rol Oluştur</a>
	            </div>
	            <div class="ibox-content">
	                <div class="table-responsive">
	            		<table class="table table-striped table-bordered table-hover dataTable" >
	            			<thead>
					            <tr>
					                <th>Rol Adı</th>
					                <th>İşlem</th>
					            </tr>
	            			</thead>
	            			<tbody>
	            				@foreach($roles as $role)
					            <tr>
					                <td>{{ $role->name }}</td>
					                <td class="center actionsColumn">
					                	@if($role->id != 1)
					                		<a 	href="{{ route('cms.user-management.roles.edit', ['role' => $role->id]) }}" 
						                		class="btn btn-sm btn-info">
						                		<i class="fa fa-edit"></i>
					                		</a>
					                		<button type="button" 
						                			class="btn btn-danger btn-sm" 
					                				data-toggle="modal" 
					                				data-target="#deleteModal{{ $role->id }}"><i class="fa fa-trash"></i>
			                				</button>
						                	@include('cms.includes.delete-modal', [ 
						                		'modal_id' => 'deleteModal'.$role->id, 
						                		'route' => 'cms.user-management.roles.delete', 
						                		'id' => ['role' => $role->id]
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