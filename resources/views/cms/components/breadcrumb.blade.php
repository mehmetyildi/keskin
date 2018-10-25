<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{ $page }}</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('home') }}" target="_blank">Web Sitesi</a>
            </li>
            <li>
                <a href="{{ route('cms.home') }}">{{ config('app.cms_name') }}</a>
            </li>
            {{ $slot }}
            <li class="active">
                <strong>{{ $page }}</strong>
            </li>
        </ol>
    </div>
</div>