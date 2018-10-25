<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" action="{{ route('cms.search') }}">
                <div class="form-group">
                    <input type="text" placeholder="Bir içerik arayın..." class="form-control" name="keyword" id="top-search" autocomplete="off">
                </div>
            </form>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <span class="m-r-sm text-muted welcome-message">{{ config('app.cms_fullname') }}</span>
            </li>
            @can('view_inbox')
            <li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    
                    <i class="fa fa-envelope"></i>  
                    @if(unreadMailCount() and auth()->user()->settings->showNotifications)
                        <span class="label label-warning">{{ unreadMailCount() }}</span>
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-messages">
                    @foreach(latestMails() as $unreadMailLink)
                    <li>
                        <div class="dropdown-messages-box">
                            <a href="{{ route('cms.inbox.detail', ['mail' => $unreadMailLink->id]) }}" class="pull-left iconLink">
                                <i class="{{ ($unreadMailLink->isRead) ? 'fa fa-envelope-open' : 'fa fa-envelope text-warning' }}"></i>
                            </a>
                            <div class="media-body">
                            <a href="{{ route('cms.inbox.detail', ['mail' => $unreadMailLink->id]) }}" class="unredMailLink">
                                <strong>Kimden: </strong> {{ $unreadMailLink->from }} <br>
                                <strong>Konu: </strong> {{ $unreadMailLink->subject }} <br>
                                <small class="text-muted">{{ $unreadMailLink->created_at->format('d/m/Y @ h:i') }}</small>
                            </a>
                            </div>
                        </div>
                    </li>
                    <li class="divider"></li>
                    @endforeach
                    <li>
                        <div class="text-center link-block">
                            <a href="{{ route('cms.inbox.index') }}">
                                <i class="fa fa-envelope"></i> <strong>Tüm Mesajları Oku</strong>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>
            @endcan
            <li>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> Çıkış</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
            <li>
                <a class="right-sidebar-toggle">
                    <i class="fa fa-gears"></i>
                </a>
            </li>
        </ul>
    </nav>
</div>