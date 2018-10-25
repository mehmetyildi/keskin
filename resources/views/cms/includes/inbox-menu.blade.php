<div class="ibox float-e-margins">
    <div class="ibox-content mailbox-content">
        <div class="file-manager">
            @can('compose_mail')
            <a class="btn btn-block btn-primary compose-mail" href="{{ route('cms.inbox.compose') }}">Yeni Oluştur</a>
            @endcan
            <div class="space-25"></div>
            <h5>Klasörler</h5>
            <ul class="folder-list m-b-md" style="padding: 0">
                <li>
                    <a href="{{ route('cms.inbox.index') }}"> 
                        <i class="fa fa-inbox "></i> Gelen Kutusu
                        @if(unreadMailCount())
                        <span class="label label-warning pull-right">
                            {{ unreadMailCount() }}
                        </span> 
                        @endif
                    </a>
                </li>
                @can('compose_mail')
                <li>
                    <a href="{{ route('cms.inbox.sent') }}"> 
                        <i class="fa fa-envelope-o"></i> Gönderilenler
                    </a>
                </li>
                @endcan
                <li>
                    <a href="{{ route('cms.inbox.important') }}"> 
                        <i class="fa fa-certificate"></i> Önemli
                    </a>
                </li>
                @can('compose_mail')
                <li>
                    <a href="{{ route('cms.inbox.drafts') }}"> 
                        <i class="fa fa-file-text-o"></i> Taslaklar 
                        @if(draftMailCount())
                        <span class="label label-danger pull-right">
                            {{ draftMailCount() }}
                        </span>
                        @endif
                    </a>
                </li>
                @endcan
                <li>
                    <a href="{{ route('cms.inbox.trash') }}"> 
                        <i class="fa fa-trash-o"></i> Çöp Kutusu
                    </a>
                </li>
            </ul>

            <h5 class="tag-title">Etiketler</h5>
            <ul class="tag-list" style="padding: 0">
                @foreach(inboxLabels() as $inboxLabel)
                    <li><a href="{{ route('cms.inbox.form', ['form' => $inboxLabel->id]) }}"><i class="fa fa-tag"></i> {{ $inboxLabel->title }}</a></li>
                    @foreach($inboxLabel->categories as $inboxCategory)
                    <li><a href="{{ route('cms.inbox.category', ['category' => $inboxCategory->id]) }}"><i class="fa fa-tag"></i> {{ $inboxCategory->title_tr }}</a></li>
                    @endforeach
                @endforeach
            </ul>
            <div class="clearfix"></div>
        </div>
    </div>
</div>