@extends('admin.layout.index')

@section('title') Admin Dashboard @endsection
@section('head')
<link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}">
@endsection

@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Forum</h4>
                <span>Tanya jawab seputar Teman Jabar</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class=" breadcrumb breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin') }}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Forum</a> </li>
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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                    Tambah
                </button>
            </div>
            <div class="card-block row">

                {{-- START LIST --}}
                <div class="col-12">
                    <ul id="topic_list" class="basic-list">

                    </ul>
                </div>
                {{-- END LIST --}}
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Tambah Topik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe height="100%" width="100%"
                    src="https://forum.temanjabar.net/ex/question/create/teman-jabar/{{$idUser}}"></iframe>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    const frameAddUrl = 'http://124.81.122.131/forum/public/ex/question/create/teman-jabar/$id_user'
    $(document).ready(function () {
        fetch('http://124.81.122.131/forum/public/api/category/teman-jabar')
            .then(res => res.json())
            .then(res => {
                console.log(res);
                res.data.forEach(element => {
                    $('#topic_list').append(`
                        <li class="card">
                            <div class="card-body">
                                <h6 class="font-weight-bold">${element.question}</h6>
                                <p>${element.description}</p>
                            </div>
                        </li>
                    `);
                });
            })
            .catch(err => console.log(err));
    });
</script>
@endsection
