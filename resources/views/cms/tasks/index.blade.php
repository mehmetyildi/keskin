@extends('layouts.cms')

@section('title') <title>{{ config('app.cms_name') }} | Yapılacaklar</title> @endsection

@section('content')
<div class="row  border-bottom white-bg dashboard-header">
    <div class="col-md-12">
        <h2>Tüm Yapılacaklar</h2>
        <small>İşlerinizi gözden geçirin.</small>
    </div>
</div>
<div class="wrapper wrapper-content">

    <div class="row">

        <div class="col-lg-12">

            <div class="row">
                <div class="col-lg-6">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h3>Yapılacaklar</h3>
                            <p class="small"><i class="fa fa-hand-o-up"></i> Listeler arasında işleri sürükleyip bırakın.</p>
                            <form action="{{ route('cms.tasks.store') }}" method="POST" id="addTaskForm" class="form-horizontal">
                                <div class="input-group">
                                    {{ csrf_field() }}
                                    <input type="text" name="description" placeholder="Yeni iş oluştur " class="input input-sm form-control" autocomplete="off">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-sm btn-white"> <i class="fa fa-plus"></i> Ekle</button>
                                    </span>
                                </div>
                            </form>
                            <div id="currentTaskList">
                                <ul class="sortable-list connectList agile-list" id="todo">
                                    @foreach($tasks->where('isDone', false)->sortBy('position') as $task)
                                    <li class="warning-element" id="{{ $task->id }}">
                                        <form action="{{ route('cms.tasks.store') }}" method="POST" class="form-horizontal updateTaskForm">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" value="{{ $task->id }}">
                                            <input class="input form-control editTaskInput" type="text" name="description" value="{{ $task->description }}" autocomplete="off">
                                            <span class="currentTaskDescription">{{ $task->description }}</span>
                                            <div class="agile-detail">
                                                <a class="pull-right btn btn-xs btn-white editTaskBtn">Düzenle</a>
                                                <button type="submit" class="pull-right btn btn-xs btn-primary updateTaskBtn">Kaydet</button>
                                                <a class="pull-right btn btn-xs btn-danger cancelTaskEditBtn">Vazgeç</a>
                                                <i class="fa fa-calendar"></i> {{ $task->created_at->format('d-m-Y') }} <i class="fa fa-user"></i> {{ $task->createdby->name }}
                                            </div>
                                        </form>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h3>Tamamlanan İşler</h3>
                            <p class="small"><i class="fa fa-hand-o-up"></i> Listeler arasında işleri sürükleyip bırakın.</p>
                            <ul class="sortable-list connectList agile-list" id="completed">
                                @foreach($tasks->where('isDone', true)->sortBy('position') as $task)
                                <li class="info-element" id="{{ $task->id }}">
                                    {{ $task->description }}
                                    <div class="agile-detail">
                                        <a href="#" class="pull-right btn btn-xs btn-primary"><i class="fa fa-check"></i></a>
                                        <i class="fa fa-clock-o"></i> {{ $task->created_at->format('d-m-Y') }} / {{ $task->createdby->name }}
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
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
<script src="{{ url('js/cms_tasks.js') }}"></script>

@endsection