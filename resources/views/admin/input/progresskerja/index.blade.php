@extends('admin.t_index')

@section('title') Progress Pekerjaan @endsection
@section('head')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables.net/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables.net/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/data-table/extensions/responsive/css/responsive.dataTables.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datepicker/bootstrap-datepicker.min.css') }}">

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
                <h4>Progress Pekerjaan</h4>
                <span>Data Progress Pekerjaan</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{url('admin')}}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Progress Pekerjaan</a> </li>
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
                <h5>Tabel Progress Pekerjaan</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <a data-toggle="modal" href="#addModal" class="btn btn-mat btn-primary mb-3">Tambah</a>
                <div class="dt-responsive table-responsive">
                    <table id="dttable" class="table table-striped table-bordered able-responsive">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Penyedia Jasa</th>
                                <th>Nama Paket</th>
                                <th>Rencana / Realisasi / Deviasi</th>
                                <th>Waktu Kontrak /Terpakai / Sisa / Prosentase</th>
                                <th>Nilai Kontrak</th>
                                <th>Keuangan Prosentase</th>
                                <th>Foto</th>
                                <th>Video</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="bodyJembatan">
                            @foreach ($pekerjaan as $data)
                            <tr>
                                <td>{{$loop->index + 1}}</td>
                                <td>{{$data->tanggal}}</td>
                                <td>{{$data->penyedia_jasa}}</td>
                                <td>{{$data->nama_paket}}</td>
                                <td>{{$data->rencana}}<br>{{$data->realisasi}}<br>{{$data->deviasi}}</td>
                                <td>{{$data->waktu_kontrak}}<br>{{$data->terpakai}}<br>{{$data->sisa}}<br>{{$data->prosentase}}</td>

                                <td>{{number_format($data->nilai_kontrak,2)}}</td>
                                <td>{{$data->bayar}}<br>{{number_format($data->bayar,2)}} %</td>
                                <td><img class="img-fluid" style="max-width: 100px" src="{!! url('storage/progresskerja/'.$data->foto) !!}" alt="" srcset=""></td>
                                <td><video width='150' height='100' controls>
                                        <source src="{!! url('storage/progresskerja/'.$data->video) !!}" type='video/*' Sorry, your browser doesn't support the video element.></video></td>
                                <!-- <td>{{$data->video}}</td> -->
                                <td>{{$data->status}}</td>
                                <td>
                                    <a href="{{ route('editDataProgress',$data->id) }}" class="mb-2 btn btn-sm btn-warning btn-mat">Edit</a><br>
                                    <a href="#delModal" data-id="{{$data->id}}" data-toggle="modal" class="btn btn-sm btn-danger btn-mat">Hapus</a>
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
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <form action="{{route('createDataProgress')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data Progress Pekerjaan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Kegiatan</label>
                            <div class="col-md-10">
                                <select class="form-control" name="kegiatan" required>
                                    @foreach ($jenis as $data)
                                    <option value="{{$data->name}}">{{$data->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Tanggal</label>
                            <div class="col-md-10">
                                <input name="tanggal" type="date" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nama Paket</label>
                            <div class="col-md-10">
                                <select class="form-control" name="nama_paket" required>
                                    @foreach ($paket as $data)
                                    <option value="{{$data}}">{{$data}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Penyedia Jasa</label>
                            <div class="col-md-10">
                                <select class="form-control" name="penyedia_jasa" required>
                                    @foreach ($penyedia as $data)
                                    <option value="{{$data}}">{{$data}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Satuan Pelayanan Pengelolaan</label>
                            <div class="col-md-10">
                                <select class="form-control" name="sup" required>
                                    @foreach ($sup as $data)
                                    <option value="{{$data->name}}">{{$data->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Ruas Jalan</label>
                            <div class="col-md-10">
                                <select class="form-control" name="ruas_jalan" required>
                                    @foreach ($ruas_jalan as $data)
                                    <option value="{{$data->nama_ruas_jalan}}">{{$data->nama_ruas_jalan}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Jenis Pekerjaan</label>
                            <div class="col-md-10">
                                <input name="jenis_pekerjaan" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Lokasi</label>
                            <div class="col-md-8">
                                <input name="lokasi" type="text" class="form-control" required>
                            </div>
                            <div class="col-md-2"> KM BDG</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Koordinat X</label>
                            <div class="col-md-10">
                                <input name="lat" type="text" class="form-control formatLatLong" required size=15>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Koordinat Y</label>
                            <div class="col-md-10">
                                <input name="lng" type="text" class="form-control formatLatLong" required size=15>
                            </div>
                        </div>
                        @if (Auth::user()->internalRole->uptd)
                        <input type="hidden" name="uptd_id" value="{{Auth::user()->internalRole->uptd}}">
                        @else
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Uptd</label>
                            <div class="col-md-10">
                                <select class="form-control" name="uptd_id">
                                    @foreach ($uptd as $data)
                                    <option value="{{$data->id}}">{{$data->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif

                        <hr>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Rencana</label>
                            <div class="col-md-6">
                                <input type="text" name="rencana" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Realisasi</label>
                            <div class="col-md-6">
                                <input type="text" name="realisasi" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Waktu Kontrak</label>
                            <div class="col-md-6">
                                <input type="text" name="waktu_kontrak" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Terpakai</label>
                            <div class="col-md-6">
                                <input type="text" name="terpakai" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Nilai Kontrak</label>
                            <div class="col-md-6">
                                <input type="text" name="nilai_kontrak" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Keuangan</label>
                            <div class="col-md-6">
                                <input type="text" name="bayar" class="form-control">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Foto Dokumentasi</label>
                            <div class="col-md-6">
                                <input name="foto" type="file" class="form-control" accept="image/*">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Video Dokumentasi</label>
                            <div class="col-md-6">
                                <input name="video" type="file" class="form-control" accept="video/*">
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
<div class="modal-only">

    <div class="modal fade" id="delModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Hapus Data Pekerjaan</h4>
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
<!-- <script src="{{ asset('assets/vendor/jquery/js/jquery-3.4.1.min.js') }}" ></script> -->
<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net/js/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('assets/vendor/datepicker/bootstrap-datepicker.min.js') }}"></script>

<script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery/js/jquery.mask.js') }}"></script>
<script>
    $(document).ready(function() {

        // Format mata uang.
        $('.formatRibuan').mask('000.000.000.000.000', {
            reverse: true
        });

        // Format untuk lat long.
        $('.formatLatLong').mask('00000.00000000', {
            reverse: true
        });

        $("#dttable").DataTable();
        $('#delModal').on('show.bs.modal', function(event) {
            const link = $(event.relatedTarget);
            const id = link.data('id');
            console.log(id);
            const url = `{{ url('admin/input-data/progresskerja/delete') }}/` + id;
            console.log(url);
            const modal = $(this);
            modal.find('.modal-footer #delHref').attr('href', url);
        });

        $('#date-start').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
        });
    });
</script>
@endsection