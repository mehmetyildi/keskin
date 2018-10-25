@extends('layouts.cms')

@section('title') <title>{{ config('app.cms_name') }} | {{ $pageName }}</title> @endsection

@section('content')

    @component('cms.components.breadcrumb')
        @slot('page') {{ $pageName }} @endslot
    @endcomponent

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h3>{{ $pageName }}</h3>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTable" >
                                <thead>
                                <tr>
                                    {{ $tHead }}
                                </tr>
                                </thead>
                                <tbody>
                                {{ $tBody }}
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
    {{ $contentScripts }}
@endsection