@extends('layouts.cms')

@section('title') <title>{{ config('app.cms_name') }} | Düzenle</title> @endsection

@section('content')

@component('cms.components.breadcrumb') 
	@slot('page') Düzenle @endslot
	<li>
		<a href="{{ route('cms.user-management.users.index') }}">Kullanıcılar</a>
	</li>
@endcomponent

<div class="wrapper wrapper-content animated fadeInRight">
   	<div class="row">
   	{!! Form::model($user, ['route' => ['cms.user-management.users.update', $user->id], 'class' => 'form-horizontal']) !!}
   		{!! method_field('PUT') !!}
	    <div class="col-lg-1 formActions">
	    	<a href="{{ route('cms.user-management.users.index') }}" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i> Geri</a>
	    	<button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save"></i> Güncelle</button>
	    	@if($user->settings->isLocked)
	    	<button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#reactivateModal"><i class="fa fa-unlock"></i> Aktive Et</button>
	    	@else
	    	<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#banModal"><i class="fa fa-ban"></i> Engelle</button>
	    	@endif
	    </div>
	    <div class="col-lg-11">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title">
	                <h5>Kullanıcıyı Düzenle <small>Bu kullanıcının rolünü değiştirebilirsiniz.</small></h5>
	                <div class="ibox-tools">
	                    <a class="collapse-link">
	                        <i class="fa fa-chevron-up"></i>
	                    </a>
	                </div>
	            </div>
	            <div class="ibox-content clearfix">
                    <div class="col-lg-6">
            			<div class="form-group">
	                    	<label class="col-sm-3 control-label">Ad Soyad</label>
	                        <div class="col-sm-9">
	                        	{!! Form::text('name', null, ['class' => 'form-control', 'readonly']) !!}
	                    	</div>
	                    </div>
	                    <div class="form-group">
	                    	<label class="col-sm-3 control-label">E-Posta</label>
	                        <div class="col-sm-9">
	                        	{!! Form::text('email', null, ['class' => 'form-control', 'readonly']) !!}
	                    	</div>
	                    </div>
	                    <div class="form-group">
                            <label for="title" class="col-sm-3 control-label">Rol</label>
                            <div class="col-sm-9">
                                {{ Form::select('role_list[]', $roles, $user->roleList, ['id' => 'role_list', 'class' => 'form-control', 'multiple', 'style' => 'display: none; width: 100%;', 'tabindex' => '-1']) }}
                            </div>  
                        </div>
            		</div>
	            </div>
	        </div>
	    </div>
    {!! Form::close() !!}
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="banModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('cms.user-management.users.ban', ['user' => $user->id]) }}" method="POST" >
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">İşlemi Onaylayın</h4>
                </div>
                <div class="modal-body">
                    Bu kullanıcıyı engellemek istediğinizden emin misiniz?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Vazgeç</button>
                    <button type="submit" class="btn btn-danger">Kullanıcıyı Engelle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="reactivateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('cms.user-management.users.reactivate', ['user' => $user->id]) }}" method="POST" >
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">İşlemi Onaylayın</h4>
                </div>
                <div class="modal-body">
                    Bu kullanıcının engelini kaldırmak istediğinize emin misiniz?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Vazgeç</button>
                    <button type="submit" class="btn btn-warning">Engellemeyi Kaldır</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
	<script>
		 $("#role_list").select2();
	</script>
@endsection