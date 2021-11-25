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
                    Teman Jabar News
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
            <div class="col-md-8 blog-main">
                <div class="blog-post">
                    <h2 class="blog-post-title">{{$news->title}}</h2>
                    <p class="blog-post-meta">{{$publishedAtForHuman}} oleh <a href="#">{{$publishedBy->name}}</a></p>

                    <p>{{$news->description}}</p>
                    <hr>
                    {!!$news->content!!}
                </div>
            </div>

            <aside class="col-md-4 blog-sidebar">
                <div class="p-4">
                    <h4 class="font-italic">Berita lainnya</h4>
                    <ol class="list-unstyled mb-0">
                        @if ($allNews->count() > 0)
                        @foreach ($allNews as $row)
                        <li><a href="{{route('news.show', $row->slug)}}">{{$row->title}}</a></li>
                        @endforeach
                        @else
                        <li>Tidak ada berita lainnya</li>
                        @endif
                    </ol>
                </div>
            </aside>
        </div>

    </main>
</body>
<script src="{{ asset('assets/vendor/jquery/js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('assets/vendor/popper.js/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
</body>

</html>
