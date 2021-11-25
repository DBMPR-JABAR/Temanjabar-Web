@extends('admin.layout.index')

@section('title') Berita @endsection

@section('header')
@endsection

@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Berita</h4>
                <span>Master Data Berita</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class=" breadcrumb breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin') }}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('news.index') }}">Berita</a>
                </li>
                <li class="breadcrumb-item"><a href="#">Tambah</a> </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('page-body')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @if ($action == 'store')
                <h5>Tambah Data Berita</h5>
                @else
                <h5>Perbaharui Data Berita</h5>
                @endif
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block pl-5 pr-5 pb-5">


                @if ($action == 'store')
                <form action="{{ route('news.store') }}" method="post" enctype="multipart/form-data">
                    @else
                    <form action="{{ route('news.update', $news->id) }}" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @endif
                        @csrf

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Published</label>
                            <div class="col-md-9">
                                <input name="published_at"
                                    value="{{ @$news->published_at ?$news->published_at->format('Y-m-d') : date('Y-m-d') }}"
                                    type="date" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Thumbnail</label>
                            <div class="col-md-4">
                                <input id="thumbnail" name="thumbnail" type="file" accept="image/*"
                                    class="form-control">
                            </div>
                            <div class="col-md-5">
                                <img style="min-height: 40px" class="mx-auto rounded img-thumbnail d-block"
                                    id="thumbnail_preview" src="{{ @$news->thumbnail }}" alt="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Judul Berita</label>
                            <div class="col-md-9">
                                <input name="title" value="{{ @$news->title }}" type="text" class="form-control"
                                    required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Deskripsi</label>
                            <div class="col-md-9">
                                <input name="description" value="{{ @$news->description }}" type="text"
                                    class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Konten</label>
                            <div class="col-md-9">
                                <textarea id="content" name="content">
                                    {!! @$news->content !!}
                                </textarea>
                            </div>
                        </div>

                        <div class=" form-group row">
                            <a href="{{ route('news.index') }}"><button type="button"
                                    class="btn btn-default waves-effect">Batal</button></a>
                            <button type="submit" class="btn btn-primary waves-effect waves-light ml-2">Simpan</button>
                        </div>
                    </form>

            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery/js/jquery.mask.js') }}"></script>

<script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
<script>
    $(document).ready(()=>{
        const editor = CKEDITOR.replace( 'content',{
                            filebrowserUploadUrl: "{{route('news.ckeditor.upload', ['_token' => csrf_token() ])}}",
                            filebrowserUploadMethod: 'form'
                        });

    editor.on( 'change', function( evt ) {
        $('#content').val(editor.getData());
    });

        const inputElement = document.getElementById('thumbnail')
        inputElement.onchange = event => {
            const [file] = inputElement.files
            if(file) document.getElementById('thumbnail_preview').src = URL.createObjectURL(file)
        }
    })
</script>
@endsection
