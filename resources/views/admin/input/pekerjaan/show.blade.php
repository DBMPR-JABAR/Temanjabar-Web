@extends('admin.t_index')

@section('title') Edit Pekerjaan @endsection

@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Jugment Pekerjaan {{Str::title($pekerjaan->nama_mandor)}}</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin') }}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('getDataPekerjaan') }}">Data Pekerjaan</a> </li>
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
                <h5>{{ Str::upper($pekerjaan->sup) }}</h5>

                <h2>{{ Str::upper($pekerjaan->status->uptd) }}</h2>
                <div class="card-header-right">
                    {{ $pekerjaan->tanggal }}
                </div>
            </div>
            <div class="card-block">

                <form action="{{ route('updateDataPekerjaan',$pekerjaan->id_pek) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_pek" value="{{$pekerjaan->id_pek}}">

                    <div class="row">
                        <div class="col-md-4">
                            <label class="col-md-6 col-form-label">Jenis Pekerjaan</label>
                            <hr>
                            <label class="col-md-12 col-form-label">{{$pekerjaan->jenis_pekerjaan}}</label>
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-6 col-form-label">Nama Paket</label>
                            <hr>
                            <label class="col-md-12 col-form-label">{{$pekerjaan->paket}}</label>
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-6 col-form-label">Jumlah Pekerja</label>
                            <hr>
                            <label class="col-md-12 col-form-label">{{$pekerjaan->jumlah_pekerja}} Orang</label>
                        </div>
                    </div>
                    
                </form>

            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Lokasi {{$pekerjaan->lokasi}}</h5>
                <br>
                <h5>{{$pekerjaan->ruas_jalan}}</h5>
                <div class="card-header-right">
                    <i class="feather icon-maximize full-card"></i>
                    <i class="feather icon-minus minimize-card"></i>
                </div>
            </div>
            <div class="card-block">

                <form action="{{ route('updateDataPekerjaan',$pekerjaan->id_pek) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        
                        <div class="col-md-6">
                            <label class="col-md-6 col-form-label">Koordinat X</label>
                            <hr>
                            <label class="col-md-12 col-form-label">{{$pekerjaan->lat}}</label>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-6 col-form-label">Koordinat Y</label>
                            <hr>
                            <label class="col-md-12 col-form-label">{{$pekerjaan->lng}}</label>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Panjang (meter)</label>
                        <label class="col-md-10 col-form-label">{{$pekerjaan->panjang}} meter</label>

                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Alat yang Digunakan</label>
                        <div class="col-md-10">
                            <input name="peralatan" type="text" class="form-control" required value="{{$pekerjaan->peralatan}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label text-center">Foto Dokumentasi (0%)</label>
                            <img style="max-height: 400px;" class="img-thumbnail rounded mx-auto d-block" src="{{ url('storage/pekerjaan/'.$pekerjaan->foto_awal) }}" alt="">
                            
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label text-center">Foto Dokumentasi (50%)</label>
                            <img style="max-height: 400px;" class="img-thumbnail rounded mx-auto d-block" src="{{ url('storage/pekerjaan/'.$pekerjaan->foto_sedang) }}" alt="">
                            
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-12 col-form-label text-center">Foto Dokumentasi (100%)</label>
                            <img style="max-height: 400px;" class="img-thumbnail rounded mx-auto d-block" src="{{ url('storage/pekerjaan/'.$pekerjaan->foto_akhir) }}" alt="">
                        
                        
                    </div>
                    <div class="form-group row">
                        <label class="col-md-12 col-form-label text-center">Video Dokumentasi</label>
                            <video  style="max-height: 400px;" controls class="img-thumbnail rounded mx-auto d-block">
                                <source src="{{ url('storage/pekerjaan/'.$pekerjaan->video) }}" type="video/mp4" />
                            </video>                
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3>Material</h3>
                <div class="card-header-right">
                    <i class="feather icon-maximize full-card"></i>
                    <i class="feather icon-minus minimize-card"></i>
                </div>
            </div>
            <div class="card-block">

                <form action="{{ route('updateDataPekerjaan',$pekerjaan->id_pek) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Alat yang Digunakan</label>
                        <div class="col-md-10">
                            <input name="peralatan" type="text" class="form-control" required value="{{$pekerjaan->peralatan}}">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <label style="font-weight: bold;">Informasi Pribadi</label>
                        <table class="table table-striped">
                            <tr>
                                <th>#</th>
                                <th>Bahan Material</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>

                            </tr>
                            <tr>
                                <td width="5%">1</td>
                                <td width="35%">Nama Lengkap</td>

                                <td width="15%">Nama Lengkap</td>
                                <td width="15%"></td>
                            </tr>
                          
                        </table>
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
<script>
    $(document).ready(function() {
        // Format mata uang.
        $('.formatRibuan').mask('000.000.000.000.000', {
            reverse: true
        });

        // Format untuk lat long.
        $('.formatLatLong').keypress(function(evt) {
            return (/^\-?[0-9]*\.?[0-9]*$/).test($(this).val() + evt.key);
        });
    });

    function ubahOption() {

        //untuk select Ruas
        id = document.getElementById("uptd").value
        url = "{{ url('admin/input-data/kondisi-jalan/getRuasJalan') }}"
        id_select = '#ruas_jalan'
        text = 'Pilih Ruas Jalan'
        option = 'nama_ruas_jalan'

        setDataSelect(id, url, id_select, text, option, option)

        //untuk select SUP
        url = "{{ url('admin/master-data/ruas-jalan/getSUP') }}"
        id_select = '#sup'
        text = 'Pilih SUP'
        option = 'name'

        setDataSelect(id, url, id_select, text, option, option)
    }
</script>
@endsection
