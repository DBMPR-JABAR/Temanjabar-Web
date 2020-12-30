@extends('admin.t_index')

@section('title') Rawan Bencana @endsection
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
                <h4>Rawan Bencana</h4>
                <span>Data Rawan Bencana</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{url('admin')}}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">RawanBencana</a> </li>
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
                <h5>Tabel Rawan Bencana</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                @if (hasAccess(Auth::user()->internal_role_id, "Rawan Bencana", "Create"))
                <a data-toggle="modal" href="#addModal" class="btn btn-mat btn-primary mb-3">Tambah</a>
                @endif
                <div class="dt-responsive table-responsive">
                    <table id="dttable" class="table table-striped table-bordered able-responsive">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Ruas</th>
                                <th>Ruas Jalan</th>
                                <th>Lokasi</th>
                                <th>Daerah</th>
                                <th>Lat</th>
                                <th>Long</th>
                                <th>Foto</th>
                                <th>SUP</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th style="min-width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <!-- <tbody id="bodyJembatan">
                            @foreach ($rawan as $data)
                            <tr>
                                <td>{{$loop->index + 1}}</td>
                                <td>{{$data->no_ruas}}</td>
                                <td>{{$data->ruas_jalan}}</td>
                                <td>{{$data->lokasi}}</td>
                                <td>{{$data->daerah}}</td>
                                <td>{{$data->lat}}</td>
                                <td>{{$data->long}}</td>
                                <td>{{$data->foto}}</td>
                                <td>{{$data->keterangan}}</td>
                                <td>{{$data->status}}</td>
                                <td style="min-width: 75px;">
                                    <div class="btn-group " role="group" data-placement="top" title="" data-original-title=".btn-xlg">
                                        @if (hasAccess(Auth::user()->internal_role_id, "Rawan Bencana", "Update"))
                                        <a href="{{ route('editDataBencana',$data->id) }}"><button data-toggle="tooltip" title="Edit" class="btn btn-primary btn-sm waves-effect waves-light"><i class="icofont icofont-pencil"></i></button></a>
                                        @endif
                                        @if (hasAccess(Auth::user()->internal_role_id, "Rawan Bencana", "Delete"))
                                        <a href="#delModal" data-id="{{$data->id}}" data-toggle="modal"><button data-toggle="tooltip" title="Hapus" class="btn btn-danger btn-sm waves-effect waves-light"><i class="icofont icofont-trash"></i></button></a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody> -->
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@if (hasAccess(Auth::user()->internal_role_id, "Rawan Bencana", "Create"))
<div class="modal-only">
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <form action="{{route('createDataBencana')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data Rawan Bencana</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <!-- <input name="uptd_id" type="hidden" class="form-control" required value="{{Auth::user()->internalRole->uptd}}"> -->

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">No Ruas</label>
                            <div class="col-md-10">
                                <input name="no_ruas" type="text" class="form-control" required>
                            </div>
                        </div>

                        @if (Auth::user()->internalRole->uptd)
                        <input type="hidden" id="uptd" name="uptd_id" value="{{str_replace('uptd','',Auth::user()->internalRole->uptd)}}">
                        @else
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Uptd</label>
                            <div class="col-md-10">
                                <select class="form-control" id="uptd" name="uptd_id" onchange="ubahOption()">
                                    <option>Pilih UPTD</option>
                                    @foreach ($uptd as $data)
                                    <option value="{{$data->id}}">{{$data->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Ruas Jalan</label>
                            <div class="col-md-10">
                                <select id="ruas_jalan" name="ruas_jalan" class="form-control" required>
                                    @if (Auth::user()->internalRole->uptd)
                                    @foreach ($ruas as $data)
                                    <option value="{{$data->nama_ruas_jalan}}">{{$data->nama_ruas_jalan}}</option>
                                    @endforeach
                                    @else
                                    <option>-</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Lokasi</label>
                            <div class="col-md-10">
                                <input name="lokasi" type="text" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Daerah</label>
                            <div class="col-md-10">
                                <input name="daerah" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Lat</label>
                            <div class="col-md-10">
                                <input name="lat" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Long</label>
                            <div class="col-md-10">
                                <input name="long" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Foto</label>
                            <div class="col-md-10">
                                <input name="foto" type="file" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">SUP</label>
                            <div class="col-md-10">
                                <select class="form-control" name="sup" id="sup">
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Status</label>
                            <div class="col-md-10">
                                <select class="form-control" name="status">
                                    <option value="P">P</option>
                                    <option value="N">N</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Keterangan</label>
                            <div class="col-md-10">
                                <textarea name="keterangan" rows="3" cols="3" class="form-control" placeholder="Masukkan Keterangan" required></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light ">Simpan</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endif

@if (hasAccess(Auth::user()->internal_role_id, "Rawan Bencana", "Delete"))
<div class="modal-only">
    <div class="modal fade" id="delModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Hapus Data Rawan Bencana</h4>
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
</div>
</div>
@endif

@endsection
@section('script')
<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net/js/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // $("#dttable").DataTable();
        $('#delModal').on('show.bs.modal', function(event) {
            const link = $(event.relatedTarget);
            const id = link.data('id');
            console.log(id);
            const url = `{{ url('admin/master-data/rawanbencana/delete') }}/` + id;
            console.log(url);
            const modal = $(this);
            modal.find('.modal-footer #delHref').attr('href', url);
        });

        var table = $('#dttable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('admin/master-data/rawanbencana/json') }}",
            columns: [{
                    'mRender': function(data, type, full, meta) {
                        return +meta.row + meta.settings._iDisplayStart + 1;

                    }
                },
                {
                    data: 'no_ruas',
                    name: 'no_ruas'
                },
                {
                    data: 'ruas_jalan',
                    name: 'ruas_jalan'
                },
                {
                    data: 'lokasi',
                    name: 'lokasi'
                },
                {
                    data: 'daerah',
                    name: 'daerah'
                },
                {
                    data: 'lat',
                    name: 'lat'
                },
                {
                    data: 'long',
                    name: 'long'
                },
                {
                    data: 'foto',
                    name: 'foto'
                },
                {
                    data: 'sup',
                    name: 'sup'
                },
                {
                    data: 'keterangan',
                    name: 'keterangan'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });

    function ubahOption() {

        //untuk select Ruas
        id = document.getElementById("uptd").value
        url = "{{ url('admin/input-data/kondisi-jalan/getRuasJalan') }}"
        id_select = '#ruas_jalan'
        text = 'Pilih Ruas Jalan'
        option = 'nama_ruas_jalan'

        setDataSelect(id, url, id_select, text, option, option);

        const baseUrl = `{{ url('admin/master-data/rawanbencana/getDataSUP/') }}/` + id;
            $.get(baseUrl, { id: id },
                function(response){
                    $('.sup').remove();
                    for(var i=0;i<response.sup.length;i++){
                        $('#sup').append("<option value='"+response.sup[i].name+"' class='sup' >"+response.sup[i].name+"</option>");
                    }
                    // $('#id').val(response.users[0].id);
                    // $('#nama').val(response.users[0].name);
                    // $('#email').val(response.users[0].email);
                    // $('#role').val(response.users[0].role);

                    // for(let i=1;i<=jml;i++){
                    //     if($("#id-"+i).val() == response.users[0].internal_role_id){
                    //         $("#id-"+i).attr("selected","selected");
                    //     }
                    // }
                });
    }
</script>
@endsection
