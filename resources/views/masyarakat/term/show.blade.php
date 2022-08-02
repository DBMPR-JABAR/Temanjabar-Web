<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Teman Jabar @yield('title')</title>
    <link type="text/css" rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Google+Sans:400,500,700">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ asset('assets/images/favicon/favicon.ico') }}" rel="icon">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/files/assets/css/font-awesome-n.min.css') }}">
</head>

<body>
    {{-- <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="{{url('/')}}">
            <img src="{{ asset('assets/images/favicon/favicon.ico') }}" width="30" height="30"
                class="d-inline-block align-top" alt="">
            Teman Jabar News
        </a>
        <div class="form-inline my-2 my-lg-0">
            <a href="{{url('/')}}" class="btn btn-outline-success my-2 my-sm-0">
                <i class="fas fa-home"></i>
            </a>
        </div>
    </nav>
    <main class="container">

    </main> --}}
    <div class="container">
        <header class="blog-header py-3">
            <nav class="navbar navbar-light bg-white">
                <a class="navbar-brand" href="{{url('/')}}">
                    <img src="{{ asset('assets/images/favicon/favicon.ico') }}" width="30" height="30"
                        class="d-inline-block align-top" alt="">
                    Teman Jabar
                </a>
                <div class="form-inline my-2 my-lg-0">
                    <a href="{{url('/')}}" class="btn btn-outline-success my-2 my-sm-0">
                        <i class="fas fa-home"></i>
                    </a>
                </div>
            </nav>
        </header>

    </div>

    <main role="main" class="container">
        <div class="row">
            <div class="col-md-12 blog-main">
                <div class="blog-post">
                    <h2 class="blog-post-title">{{$term->title}}</h2>
                    <p class="blog-post-meta">Diperbaharui per tanggal: {{$publishedAtForHuman}}</p>
                    <hr>
                    {!!$term->content!!}
                </div>
            </div>
        </div>

    </main>
</body>
<script src="{{ asset('assets/vendor/jquery/js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('assets/vendor/popper.js/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
</body>

</html>
