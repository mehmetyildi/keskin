<div id="right-sidebar" class="animated">
    <div class="sidebar-container">

        <ul class="nav nav-tabs navs-3 darker">
            <li class="active"><a data-toggle="tab" href="#tab-3">
                Ayarlar
            </a></li>
        </ul>

        <div class="tab-content">



            <div id="tab-3" class="tab-pane active">

                <div class="sidebar-title">
                    <h3><i class="fa fa-gears"></i> Ayarlar</h3>
                    <small><i class="fa fa-tim"></i> {{ config('app.cms_name') }}'i kendinize göre düzenleyin.</small>
                </div>
                <form method="POST" action="{{ route('cms.change-settings') }}" role="form">
                    {{ csrf_field() }}
                    <div class="setings-item">
                        <span>
                            Bildirim etiketlerini göster
                        </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="showNotifications" {{ auth()->user()->settings->showNotifications ? "checked" : "" }} class="onoffswitch-checkbox" id="showNotifications" >
                                <label class="onoffswitch-label" for="showNotifications">
                                    <span class="onoffswitch-inner" data-on="Evet" data-off="Hayır"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
                        <span>
                            Sol menüyü kapat
                        </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="isSidebarClosed" {{ auth()->user()->settings->isSidebarClosed ? "checked" : "" }} class="onoffswitch-checkbox" id="isSidebarClosed" >
                                <label class="onoffswitch-label" for="isSidebarClosed">
                                    <span class="onoffswitch-inner" data-on="Evet" data-off="Hayır"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item" style="display: none !important;">
                        <span>
                            Dil
                        </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="language" {{ (auth()->user()->settings->language == "en") ? "checked" : "" }} class="onoffswitch-checkbox" id="language">
                                <label class="onoffswitch-label" for="language">
                                    <span class="onoffswitch-inner" data-on="EN" data-off="TR"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item clearfix">
                        <div class="switch">
                            <button type="submit" class="btn btn-primary btn-sm">Değişiklikleri Kaydet</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>