@extends('admin.t_index')

@section('title') Ruas Jalan @endsection
@section('head')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables.net/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables.net/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/data-table/extensions/responsive/css/responsive.dataTables.css') }}">

<link rel="stylesheet" href="https://js.arcgis.com/4.17/esri/themes/light/main.css">

<style>
    table.table-bordered tbody td {
        word-break: break-word;
        vertical-align: top;
    }
</style>
@endsection

@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Ruas Jalan</h4>
                <span>Data Seluruh Ruas Jalan</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{url('admin')}}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Ruas Jalan</a> </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('page-body')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Tabel Ruas Jalan</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                @if (hasAccess(Auth::user()->internal_role_id, "Ruas Jalan", "Create"))
                <a data-toggle="modal" href="#addModal" class="btn btn-mat btn-primary mb-3">Tambah</a>
                @endif
                <div class="dt-responsive table-responsive">
                    <table id="dttable" class="table table-striped table-bordered able-responsive">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Id Jalan</th>
                                <th>Nama Ruas Jalan</th>
                                <th>Sup</th>
                                <th>Lokasi</th>
                                <th>Panjang (meter)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="bodyJembatan">
                            @foreach ($ruasJalan as $data)
                            <tr>
                                <td>{{$loop->index + 1}}</td>
                                <td>{{$data->id_ruas_jalan}}</td>
                                <td>{{$data->nama_ruas_jalan}}</td>
                                <td>{{$data->supName}}</td>
                                <td>{{$data->lokasi}}</td>
                                <td>{{$data->panjang}}</td>
                                <td>
                                    <div class="btn-group " role="group" data-placement="top" title="" data-original-title=".btn-xlg">
                                        @if (hasAccess(Auth::user()->internal_role_id, "Ruas Jalan", "Update"))
                                        <a href="{{ route('editMasterRuasJalan',$data->id) }}" class="btn btn-primary btn-sm waves-effect waves-light"><i class="icofont icofont-pencil"></i>Edit</a>
                                        @endif
                                        @if (hasAccess(Auth::user()->internal_role_id, "Ruas Jalan", "Delete"))
                                        <a href="#delModal" data-id="{{$data->id}}" data-toggle="modal" class="btn btn-danger btn-sm waves-effect waves-light"><i class="icofont icofont-trash"></i>Hapus</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-only">
    @if (hasAccess(Auth::user()->internal_role_id, "Ruas Jalan", "Delete"))
    <div class="modal fade" id="delModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Hapus Data Ruas Jalan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data ini?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
                    <a id="delHref" href="" class="btn btn-danger waves-effect waves-light ">Hapus</a>
                </div>

            </div>
        </div>
    </div>
    @endif
</div>

<div class="modal-only">
    @if (hasAccess(Auth::user()->internal_role_id, "Ruas Jalan", "Create"))
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <form action="{{route('createMasterRuasJalan')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data Ruas Jalan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body p-5">

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Id Ruas Jalan</label>
                            <div class="col-md-9">
                                <input name="id_ruas_jalan" type="text" class="form-control" maxlength="6" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Nama Ruas Jalan</label>
                            <div class="col-md-9">
                                <input name="nama_ruas_jalan" type="text" class="form-control" required>
                            </div>
                        </div>

                        @if (Auth::user()->internalRole->uptd)
                        <input id="uptd_id" name="uptd_id" type="number" class="form-control" value="{{str_replace('uptd', '', Auth::user()->internalRole->uptd)}}" hidden>
                        @else
                        <div class=" form-group row">
                            <label class="col-md-3 col-form-label">UPTD</label>
                            <div class="col-md-9">
                                <select class="form-control select2" id="uptd_id" name="uptd_id" style="min-width: 100%;" onchange="ubahDataSUP()">
                                    <option>Pilih UPTD</option>
                                    @foreach ($uptd as $uptdData)
                                    <option value="{{$uptdData->id}}">{{$uptdData->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">SUP</label>
                            <div class="col-md-9">
                                <select class="form-control select2" id="sup" name="sup" style="min-width: 100%;">
                                    @if (Auth::user()->internalRole->uptd)
                                    @foreach ($sup as $supData)
                                    <option value="<?php echo $supData->id; ?>"><?php echo $supData->name; ?></option>
                                    @endforeach
                                    @else
                                    <option>-</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Lokasi</label>
                            <div class="col-md-9">
                                <input name="lokasi" type="text" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Panjang (meter)</label>
                            <div class="col-md-9">
                                <input name="panjang" type="text" class="form-control formatRibuan" required>
                            </div>
                        </div>

                        <!-- <div class="form-group row">
                            <label class="col-md-3 col-form-label">Status Awal</label>
                            <div class="col-md-9">
                                <input name="sta_awal" type="number" step="any" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Status Akhir</label>
                            <div class="col-md-9">
                                <input name="sta_akhir" type="number" step="any" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Lat Awal</label>
                            <div class="col-md-9">
                                <input name="lat_awal" type="text" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Long Awal</label>
                            <div class="col-md-9">
                                <input name="long_awal" type="text" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Lat Akhir</label>
                            <div class="col-md-9">
                                <input name="lat_akhir" type="text" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Long Akhir</label>
                            <div class="col-md-9">
                                <input name="long_akhir" type="text" class="form-control" required>
                            </div>
                        </div> -->
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light ">Simpan</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="delModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Hapus Data Ruas Jalan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data ini?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
                    <a id="delHref" href="" class="btn btn-danger waves-effect waves-light ">Hapus</a>
                </div>

            </div>
        </div>
    </div>
    </li>
    @endif
</div>
@endsection
@section('script')
<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net/js/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery/js/jquery.mask.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#dttable").DataTable();
        $('#delModal').on('show.bs.modal', function(event) {
            const link = $(event.relatedTarget);
            const id = link.data('id');
            console.log(id);
            const url = `{{ url('admin/master-data/ruas-jalan/delete') }}/` + id;
            console.log(url);
            const modal = $(this);
            modal.find('.modal-footer #delHref').attr('href', url);
        });

        // Format mata uang.
        $('.formatRibuan').mask('000.000.000.000.000', {
            reverse: true
        });
    });

    function ubahDataSUP() {

        val = document.getElementById("uptd_id").value

        $.ajax({
            url: "{{ url('admin/master-data/ruas-jalan/getSUP') }}",
            method: 'get',
            dataType: 'JSON',
            data: {
                id: val
            },
            complete: function(result) {
                $('#sup').empty(); // remove old options
                $('#sup').append($("<option></option>").text('Pilih SUP'));

                result.responseJSON.forEach(function(item) {
                    $('#sup').append($("<option></option>").attr("value", item["name"]).text(item["name"]));
                });
            }
        });
    }
</script>
@endsection