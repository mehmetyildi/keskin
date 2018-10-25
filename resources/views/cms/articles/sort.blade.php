@extends('layouts.cms')

@section('title') <title>{{ config('app.cms_name') }} | Sıralama</title> @endsection

@section('content')

@component('cms.components.breadcrumb') 
	@slot('page') Sıralama @endslot
	<li>
		<a href="{{ route('cms.'.$pageUrl.'.index') }}">{{ $pageName }}</a>
	</li>
@endcomponent

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
    	<div class="col-lg-1 formActions">
	    	<a href="{{ route('cms.'.$pageUrl.'.index') }}" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i> Geri</a>
	    </div>
        <div class="col-lg-6">
            <div class="ibox">
                <div class="ibox-content">
                    <h3>{{ $pageName }} | Sıralama</h3>
                    <p class="small"><i class="fa fa-hand-o-up"></i> Sürükle &amp; Bırak</p>
                    <div id="currentTaskList">
	                    <ul class="sortable-list connectList agile-list" id="sort-list">
	                        @foreach($records->sortBy('position') as $record)
	                        <li class="warning-element" id="{{ $record->id }}">
	                            <form action="{{ route('cms.tasks.store') }}" method="POST" class="form-horizontal updateTaskForm">
	                            {{ csrf_field() }}
	                            <input type="hidden" name="id" value="{{ $record->id }}">
	                            <span class="currentTaskDescription">{{ $record->title_tr }}</span>
	                            <div class="agile-detail">
	                                <i class="fa fa-calendar"></i> {{ $record->created_at->format('d-m-Y') }} <i class="fa fa-user"></i> {{ $record->createdby->name }}
	                            </div>
								</form>
	                        </li>
	                        @endforeach
	                    </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
	<!-- jQuery UI -->
	<script src="{{ url('cms/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
	<script>
        $(document).ready(function(){
            $("#sort-list").sortable({
		        update: function( event, ui ) {
		            var records = $( "#sort-list" ).sortable( "toArray" );
		            $.ajax({
		                data: { ids : window.JSON.stringify(records), _token: window.Laravel.csrfToken},
		                type: 'POST',
		                url: globalBaseUrl + '/{{ config("app.cms_path") }}/'+'{{ $pageUrl }}'+'/sort-records',
		                success: function(response) {
		                    toastr.success('Sıralama yapıldı');
		                },
		            });
		        }        
		    }).disableSelection();
        });
    </script>
@endsection