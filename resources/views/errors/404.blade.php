<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.cms_name') }} | 404 Error</title>

    <link href="{{ url('/cms/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('/cms/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ url('/cms/css/animate.css') }}" rel="stylesheet">
    <link href="{{ url('/cms/css/style.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">


    <div class="middle-box text-center animated fadeInDown">
        <h1>404</h1>
        <h3 class="font-bold">Page Not Found</h3>

        <div class="error-desc">
            Sorry, but the page you are looking for has note been found. Try checking the URL for error, then hit the refresh button on your browser or try found something else in our app.
            <br>
            <br>
            <a class="btn btn-primary" href="{{ route('home') }}"><i class="fa fa-home"></i> Go To Homepage</a>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ url('/cms/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ url('/cms/js/bootstrap.min.js') }}"></script>

</body>

</html>
