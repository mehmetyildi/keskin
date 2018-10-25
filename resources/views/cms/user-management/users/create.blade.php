@extends('layouts.cms')

@section('title') <title>{{ config('app.cms_name') }} | Yeni Kullanıcı Davet Et</title> @endsection

@section('content')

@component('cms.components.breadcrumb') 
	@slot('page') Yeni Kullanıcı Davet Et @endslot
	<li>
		<a href="{{ route('cms.user-management.users.index') }}">Kullanıcılar</a>
	</li>
@endcomponent

<div class="wrapper wrapper-content animated fadeInRight">
   	<div class="row">
	{!! Form::open(['route' => 'cms.user-management.users.store', 'class' => 'form-horizontal']) !!}
	    <div class="col-lg-1 formActions">
	    	<a href="{{ route('cms.user-management.users.index') }}" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i> Geri</a>
	    	<button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-envelope"></i> Davet Et</button>
	    </div>
	    <div class="col-lg-11">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title">
	                <h5>Yeni Kullanıcı <small>Bir kullanıcıyı eklediğinizde, davet e-postası otomatik olarak gönderilecektir.</small></h5>
	                <div class="ibox-tools">
	                    <a class="collapse-link">
	                        <i class="fa fa-chevron-up"></i>
	                    </a>
	                </div>
	            </div>
	            <div class="ibox-content">
	            	<div class="row">
	            		<div class="col-lg-6">
	            			<div class="form-group">
		                    	<label class="col-sm-3 control-label">Ad Soyad</label>
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
		                    	<label class="col-sm-3 control-label">E-Posta</label>
		                        <div class="col-sm-9">
		                        	{!! Form::text('email', null, ['class' => 'form-control', 'required']) !!}
			                    	@if($errors->has('email'))
				                        <span class="help-block">
				                            <strong>{{ $errors->first('email') }}</strong>
				                        </span>
				                    @endif
		                    	</div>
		                    </div>
		                    <div class="form-group">
	                            <label for="title" class="col-sm-3 control-label">Rol</label>
	                            <div class="col-sm-9">
	                                <select class="select2 form-control" required name="role_id" tabindex="-1" style="display: none; width: 100%">
	                                    <option></option>
                                        @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
	                                </select>
	                            </div>  
	                        </div>
	            		</div>
	            	</div>
	            </div>
	        </div>
	    </div>
    {!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')
	<script>
		$(".select2").select2({placeholder: 'Rol Seçiniz'});
	</script>
@endsection