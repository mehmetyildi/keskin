@extends('layouts.cms')

@section('title') <title>{{ config('app.cms_name') }} | Anasayfa</title> @endsection

@section('styles')
    <link href="{{ url('cms/css/plugins/morris/morris-0.4.3.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row  border-bottom white-bg dashboard-header">
    <div class="col-md-12">
        <h2>{{ trans('cms.greet') }}, {{ strtok(auth()->user()->name,  ' ') }}</h2>
        <small>En son oturum: {{ previousLogin() }}</small>
    </div>
</div>
<div class="wrapper wrapper-content">
	@if(config('app.env') == 'production')
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">Son 30 Gün</span>
                    <h5>En Çok Ziyaret Edilen Sayfa</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $mostVisitedPage['url'] }}</h1>
                    <small>{{ $mostVisitedPage['pageViews'] }} Görüntüleme</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">Son 60 Gün</span>
                    <h5>Toplam Ziyaret</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $totalVisitorsAndPageViews->sum('pageViews') }}</h1>
                    <small>Görüntüleme</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">Son 30 Gün</span>
                    <h5>En Çok Kullanılan Tarayıcı</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $topBrowser['browser'] }}</h1>
                    <small>{{ $topBrowser['sessions'] }} seans</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-danger pull-right">Son 30 Gün</span>
                    <h5>En Çok Kullanılan OS</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $topOs['rows'][0][0] }}</h1>
                    <small>{{ $topOs['rows'][0][1] }} Görüntüleme</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Trafik</h5>
                            <span class="pull-right text-right">
                            <small>Son <strong>60</strong> gün</small>
                            </span>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div>
                                        <canvas id="lineChart" height="111"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Yeni Oturum</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-xs-6">
                                    <small class="stats-label">URL</small>
                                </div>

                                <div class="col-xs-6 centerAlign">
                                    <small class="stats-label">%</small>
                                </div>
                            </div>
                        </div>
                        @if($newSessions['rows']))
                        @if(count($newSessions['rows']))
                            @foreach(array_slice($newSessions['rows'], 0, 4) as $newSession)
                                <div class="ibox-content">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <h4>{{ $newSession[0] }}</h4>
                                        </div>

                                        <div class="col-xs-6 centerAlign">
                                            <h4>%{{ round($newSession[1], 2) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        @else
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <h4>Gösterilecek bir veri yok</h4>
                                    </div>

                                    <div class="col-xs-6 centerAlign">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>En Çok Yönlendiren</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-xs-6">
                                    <small class="stats-label">URL</small>
                                </div>

                                <div class="col-xs-6 centerAlign">
                                    <small class="stats-label">Görüntüleme</small>
                                </div>
                            </div>
                        </div>
                        @if(count($topReferrers))
                            @foreach($topReferrers as $referrer)
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <h4>{{ $referrer['url'] }}</h4>
                                    </div>

                                    <div class="col-xs-6 centerAlign">
                                        <h4>{{ $referrer['pageViews'] }}</h4>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-xs-6">
                                    <h4>Gösterilecek bir veri yok</h4>
                                </div>

                                <div class="col-xs-6 centerAlign">
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
	@endif
    <div class="row">
        @can('view_inbox')
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Mesajlar</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                @unless($mails->isEmpty())
                <div class="ibox-content ibox-heading">
                    <h3><i class="fa fa-envelope-o"></i> En son mesajlar</h3>
                    <small><i class="fa fa-tim"></i></small>
                </div>
                @else
                <div class="ibox-content ibox-heading">
                    <h3><i class="fa fa-exclamation"></i> Yeni bir şey yok!</h3>
                    <small><i class="fa fa-tim"></i></small>
                </div>
                @endunless
                <div class="ibox-content">
                    <div class="feed-activity-list">
                        @foreach($mails as $mail)
                        <div class="feed-element">
                            <a class="text-primary" href="{{ route('cms.inbox.detail', ['mail' => $mail->id]) }}">
                                <div>
                                <i class="{{ ($mail->isRead) ? 'fa fa-envelope-open' : 'fa fa-envelope text-warning' }}"></i>
                                    <strong>{{ $mail->subject }}</strong>
                                    <div>{{ $mail->from }}</div>
                                    <small class="text-muted">{{ $mail->created_at->format('d/m/Y @ h:i') }}</small>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endcan

        <div class="col-lg-8">
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
                                    </li>
                                    </form>
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
                                @foreach($tasks->where('isDone', true)->sortBy('position')->take(10) as $task)
                                <li class="info-element" id="{{ $task->id }}">
                                    {{ $task->description }}
                                    <div class="agile-detail">
                                        <a href="#" class="pull-right btn btn-xs btn-primary"><i class="fa fa-check"></i></a>
                                        <i class="fa fa-calendar"></i> {{ $task->created_at->format('d-m-Y') }} <i class="fa fa-user"></i> {{ $task->createdby->name }}
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
<!-- ChartJS-->
<script src="{{ url('cms/js/plugins/chartJs/Chart.min.js') }}"></script>
@if(config('app.env') == 'production')
<script>
   $(document).ready(function() {

        var lineData = {
            labels: [
            @foreach($totalVisitorsAndPageViews as $label)
            "{{ $label['date']->format('d.m.y') }}", 
            @endforeach
            ],
            datasets: [
                {
                    label: "Görüntüleme",
                    backgroundColor: "rgba(26,179,148,0.2)",
                    borderColor: "rgba(26,179,148,0.7)",
                    pointBackgroundColor: "rgba(26,179,148,1)",
                    pointBorderColor: "#fff",
                    data: [
                        @foreach($totalVisitorsAndPageViews as $data)
                        {{ $data['pageViews'] }}, 
                        @endforeach
                    ]
                }
            ]
        };

        var lineOptions = {
            responsive: true,
            elements: {
                line: {
                    tension: 0.1
                }
            }
        };


        var ctx = document.getElementById("lineChart").getContext("2d");
        new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});


    });
</script>
@endif
@endsection