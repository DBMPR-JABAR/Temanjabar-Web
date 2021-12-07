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
            {{-- <div class="card-header">
                <h5>Forum</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div> --}}
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

@endsection
@section('script')
<script>
    $(document).ready(function () {
        fetch('http://124.81.122.131/forum/public/api/category/teman-jabar')
            .then(res => res.json())
            .then(res => {
                console.log(res);
                res.data.forEach(element => {
                    $('#topic_list').append(`
                        <li class="card-block">
                            <h6 class="font-weight-bold">${element.question}</h6>
                            <p>${element.description}</p>
                        </li>
                    `);
                });
            })
            .catch(err => console.log(err));
    });
</script>
@endsection
