<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{ url('cms/favicon.ico') }}" /> 
    @yield('title')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ url('cms/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('cms/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <!-- Toastr style -->
    <link href="{{ url('cms/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ url('cms/css/plugins/select2/select2.min.css') }}" rel="stylesheet">

    <!-- Gritter -->
    <link href="{{ url('cms/js/plugins/gritter/jquery.gritter.css') }}" rel="stylesheet">
    <link href="{{ url('cms/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">

    <link href="{{ url('cms/css/animate.css') }}" rel="stylesheet">
    <link href="{{ url('cms/css/style.css') }}" rel="stylesheet">
    <link href="{{ url('css/cms.css') }}" rel="stylesheet">
    <link href="{{ asset('cms/css/plugins/blueimp/css/blueimp-gallery.min.css') }}" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            ]) !!};
        var globalBaseUrl ='<?php echo url('/'); ?>';
    </script>
    @yield('styles')
</head>

<body class="{{ auth()->user()->settings->isSidebarClosed ? 'mini-navbar' : '' }}">
    <div id="wrapper">
        @include('cms.includes.side-nav')

        <div id="page-wrapper" class="gray-bg dashbard-1">
            @include('cms.includes.top-bar')
            
            <!-- Page Content -->
            @yield('content')
            <!-- End Page Content -->
        </div>
        

        @include('cms.includes.right-tabs')

    </div>

    <!-- The Gallery as lightbox dialog, should be a child element of the document body -->
    <div id="blueimp-gallery" class="blueimp-gallery">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
    </div>
    <!-- Mainly scripts -->
    <script src="{{ url('cms/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ url('cms/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('cms/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ url('cms/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ url('cms/js/plugins/dataTables/datatables.min.js') }}"></script>

    <!-- Flot -->
    <script src="{{ url('cms/js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ url('cms/js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ url('cms/js/plugins/flot/jquery.flot.spline.js') }}"></script>
    <script src="{{ url('cms/js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ url('cms/js/plugins/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ url('cms/js/plugins/flot/jquery.flot.symbol.js') }}"></script>
    <script src="{{ url('cms/js/plugins/flot/jquery.flot.time.js') }}"></script>
    <script src="{{ url('cms/js/plugins/flot/curvedLines.js') }}"></script>

    <!-- Summernote -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>

    <!-- Select2 -->
    <script src="{{ url('cms/js/plugins/select2/select2.full.min.js') }}"></script>

    <!-- Peity -->
    <script src="{{ url('cms/js/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ url('cms/js/demo/peity-demo.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ url('cms/js/inspinia.js') }}"></script>
    <script src="{{ url('cms/js/plugins/pace/pace.min.js') }}"></script>

    <!-- Touch Punch - Touch Event Support for jQuery UI -->
    <script src="{{ url('cms/js/plugins/touchpunch/jquery.ui.touch-punch.min.js') }}"></script>

    <!-- GITTER -->
    <script src="{{ url('cms/js/plugins/gritter/jquery.gritter.min.js') }}"></script>

    <!-- Sparkline -->
    <script src="{{ url('cms/js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Sparkline demo data  -->
    <script src="{{ url('cms/js/demo/sparkline-demo.js') }}"></script>

    <!-- ChartJS-->
    <script src="{{ url('cms/js/plugins/easypiechart/jquery.easypiechart.js') }}"></script>

    <!-- Toastr -->
    <script src="{{ url('cms/js/plugins/toastr/toastr.min.js') }}"></script>

    <!-- CK Editor -->
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

    <!-- blueimp gallery -->
    <script src="{{ asset('cms/js/plugins/blueimp/jquery.blueimp-gallery.min.js') }}"></script>
    <script src="{{ asset('js/cms.js') }}"></script>


    @if(Session::has('success') || Session::has('danger')|| Session::has('messages'))
    <script>
        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @elseif(Session::has('danger'))
            toastr.error("{{ Session::get('danger') }}");
        
        @endif
    </script>
    @endif
    @yield('scripts')
    
</body>
</html>
