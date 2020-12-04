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
                <h4>Kondisi Jalan</h4>
                <span>Data Seluruh Kondisi Jalan</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{url('admin')}}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Kondisi Jalan</a> </li>
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
                <h5>Tabel Kondisi Jalan</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <a href="{{ route('addIDDataPaket') }}" class="btn btn-mat btn-primary mb-3">Tambah</a>
                <div class="dt-responsive table-responsive">
                    <table id="dttable" class="table table-striped table-bordered able-responsive">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Paket</th>
                                <th>Lokasi Pekerjaan</th>
                                <th>Pagu Anggaran</th>
                                <th>Target Panjang</th>
                                <th>Waktu Pelaksanaan (HK)</th>
                                <th>Jenis Penanganan</th>
                                <th>Penyedia Jasa</th>
                                <th>No. Kontrak</th>
                                <th>Tanggal Kontrak</th>
                                <th>Nilai Kontrak</th>
                                <th>Nilai Tambahan</th>
                                <th>Nilai Kontrak Perubahan</th>
                                <th>Total Tambahan</th>
                                <th>Total Sisa Lelang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="bodyJembatan">
                            @foreach ($dataPaket as $data)
                            <tr>
                                <td>{{$loop->index + 1}}</td>
                                <td width='50px'>{{$data->nama_paket}}</td>
                                <td>{{$data->lokasi_pekerjaan}}</td>
                                <td>{{$data->pagu_anggaran}}</td>
                                <td>{{$data->target_panjang}}</td>
                                <td>{{$data->waktu_pelaksanaan_hk}}</td>
                                <td>{{$data->jenis_penanganan}}</td>
                                <td>{{$data->penyedia_jasa}}</td>
                                <td>{{$data->nomor_kontrak}}</td>
                                <td>{{$data->tgl_kontrak}}</td>
                                <td>{{$data->nilai_kontrak}}</td>
                                <td>{{$data->nilai_tambahan}}</td>
                                <td>{{$data->nilai_kontrak_perubahan}}</td>
                                <td>{{$data->total_tambahan}}</td>
                                <td>{{$data->total_sisa_lelang}}</td>
                                <td>
                                    <a href="{{ route('editIDDataPaket',$data->kode_paket) }}" class="mb-2 btn btn-sm btn-warning btn-mat">Edit</a><br>
                                    <a href="#delModal" data-id="{{$data->kode_paket}}" data-toggle="modal" class="btn btn-sm btn-danger btn-mat">Hapus</a>
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

    <div class="modal fade" id="delModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Hapus Data Paket</h4>
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

@endsection
@section('script')
<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net/js/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#dttable").DataTable();
        $('#delModal').on('show.bs.modal', function(event) {
            const link = $(event.relatedTarget);
            const id = link.data('id');
            console.log(id);
            const url = `{{ url('admin/input-data/data-paket/delete') }}/` + id;
            console.log(url);
            const modal = $(this);
            modal.find('.modal-footer #delHref').attr('href', url);
        });
    });
</script>
@endsection