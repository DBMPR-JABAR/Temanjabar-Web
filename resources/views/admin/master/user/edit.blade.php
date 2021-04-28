@extends('admin.layout.index')

@section('title') Edit User @endsection
@section('head')
<link rel="stylesheet" href="{{ asset('assets/vendor/chosen_v1.8.7/chosen.css') }}">

@endsection
@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Edit User</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class=" breadcrumb breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin') }}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('getMasterUser') }}">User</a> </li>
                <li class="breadcrumb-item"><a href="#">Edit</a> </li>
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
                <h5>Edit Data User</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        {{-- <li><i class="feather icon-maximize full-card"></i></li> --}}
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">

                <form action="{{ route('updateUser') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$users->id}}">

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Email</label>
                        <div class="col-md-10">
                            <input name="email" type="email" class="form-control" value="{{$users->email}}" required>
                            <small class="form-text text-muted">Tidak bisa diedit</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Password</label>
                        <div class="col-md-10">
                            <div class="row" style="margin-left: 0px; margin-right: 0px;">
                                <input id="password-field" name="password" type="password" class="form-control">
                                <span style="cursor: pointer; margin-left: -30px;" class="ti-eye my-auto toggle-password" toggle="#password-field"></span>
                            </div>
                            <small class="form-text text-muted">Kosongkan jika tidak akan merubah password</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Nama Lengkap</label>
                        <div class="col-md-10">
                            <input name="name" type="text" class="form-control" value="{{$users->name}}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">NIP/NIK</label>
                        <div class="col-md-10">
                            <input name="no_pegawai" type="text" class="form-control" value="{{@$users->pegawai->no_pegawai}}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">No. Telp/HP</label>
                        <div class="col-md-10">
                            <input name="no_tlp" type="text" class="form-control" value="{{@$users->pegawai->no_tlp}}" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">SUP</label>
                        <div class="col-md-10">
                            <select class="form-control searchableField" name="sup_id">
                                <option value=" , ">Pilih SUP</option>
                                @foreach ($sup as $data)
                                <option value="{{ $data->id }},{{ $data->name }}" @if($users->sup_id == $data->id) selected @endif>{{$data->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Ruas Jalan</label>
                        <div class="col-md-10">
                            <select data-placeholder="Ruas jalan" class="form-control chosen-select" multiple id="ruas_jalan" name="ruas_jalan[]" tabindex="4">
                                <option value=" ">Pilih Ruas</option>
                                    @foreach ($input_ruas_jalan as $data)
                                    <option value="{{$data->id}}" @if(@$users->ruas && in_array($data->id,array_column( @$users->ruas->toArray(), 'id'))) selected @endif>{{@$data->nama_ruas_jalan}}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Pilih Jabatan</label>
                        <div class="col-md-10">
                            <select class="form-control searchableField" required name="internal_role_id">
                                <option>Pilih Jabatan</option>
                                @foreach ($role as $data)
                                <option value="{{$data->id}}" @if($user->internal_role_id == $data->id) selected @endif>{{$data->role}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Blokir</label>
                        <div class="col-md-10">
                            <label class="radio-inline">
                                <input type="radio" name="blokir" value="Y" @if($user->blokir=='Y') checked @endif> Y
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="blokir" value="N" @if($user->blokir=='N') checked @endif> N
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-mat btn-success">Simpan Perubahan</button>
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
<script type="text/javascript" src="{{ asset('assets/vendor/chosen_v1.8.7/chosen.jquery.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $(".chosen-select").chosen( { width: '100%' } );
    });
</script>
<script>
    $(".toggle-password").click(function() {
        $(this).toggleClass("ti-eye ti-lock");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
</script>
@endsection
