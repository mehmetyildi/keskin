@extends('layouts.cms')

@section('title') <title>{{ config('app.cms_name') }} | Kullanıcılar</title> @endsection

@section('content')

@component('cms.components.breadcrumb') 
	@slot('page') Kullanıcılar @endslot
@endcomponent

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title">
            		<a 	href="{{ route('cms.user-management.users.create') }}" class="btn btn-sm btn-primary clearfix">
        				<i class="fa fa-plus-circle"></i> Yeni Kullanıcı Davet Et
        			</a>
	            </div>
	            <div class="ibox-content">
	                <div class="table-responsive">
	            		<table class="table table-striped table-bordered table-hover dataTable" >
	            			<thead>
					            <tr>
					                <th>Ad Soyad</th>
					                <th>Rol</th>
					                <th>Durum</th>
					                <th>İşlem</th>
					            </tr>
	            			</thead>
	            			<tbody>
	            				@foreach($users as $user)
					            <tr>
					                <td>{{ $user->name }}</td>
					                <td>{{ $user->role->name }}</td>
					             
					                <td>{{ ($user->user) ? (($user->user->settings->isLocked) ? 'Engelli' : 'Aktif') : 'Hesap Oluşturulmadı' }}</td>
					                <td class="center actionsColumn" style="width:102px;">
					                	@if($user->user)
					                		<a 	href="{{ route('cms.user-management.users.edit', ['role' => $user->user->id]) }}" 
					                			class="btn btn-sm btn-info">
					                			<i class="fa fa-edit"></i>
				                			</a>
					                	@else
					                		<button disabled class="btn btn-sm btn-info">Bekliyor</button>
					                		<button type="button" 
						                			class="btn btn-danger btn-sm" 
					                				data-toggle="modal" 
					                				data-target="#deleteModal{{ $user->id }}"><i class="fa fa-trash"></i>
			                				</button>
						                	@include('cms.includes.delete-modal', [ 
						                		'modal_id' => 'deleteModal'.$user->id, 
						                		'route' => 'cms.user-management.users.delete', 
						                		'id' => ['invitee' => $user->id]
				                			]) 
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