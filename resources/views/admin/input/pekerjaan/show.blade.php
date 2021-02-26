@extends('admin.t_index')

@section('title') Edit Pekerjaan @endsection

@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Jugment Pekerjaan </h4>
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


                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Mandor</label>
                        
                        <label class="col-md-10 col-form-label"> {{Str::title($pekerjaan->nama_mandor)}}</label>

                           
                 
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Jenis Pekerjaan</label>
                        <div class="col-md-10">
                            <select class="form-control searchableField" name="jenis_pekerjaan" required >
                               
                                <option value="" >{{$pekerjaan->jenis_pekerjaan}}</option>
                            
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Nama Paket</label>
                        <div class="col-md-10">
                            <input name="paket" type="text" class="form-control" value="{{$pekerjaan->paket}}">
                        </div>
                    </div>
                    @if (Auth::user()->internalRole->uptd)
                    <input type="hidden" id="uptd" name="uptd_id" value="{{Auth::user()->internalRole->uptd}}" value="{{$pekerjaan->uptd_id}}">
                    @else
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Uptd</label>
                        <div class="col-md-10">
                            <select class="form-control searchableField" id="uptd" name="uptd_id" value="{{$pekerjaan->uptd_id}}" onchange="ubahOption()">
                                @foreach ($uptd as $pekerjaan)
                                <option value="{{$pekerjaan->id}}" {{ ( $pekerjaan->id == $pekerjaan->uptd_id) ? 'selected' : ''}}>{{$pekerjaan->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                   
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Ruas Jalan</label>
                        <div class="col-md-10">
                            <select class="form-control searchableField" id="ruas_jalan" name="ruas_jalan" required value="{{$pekerjaan->ruas_jalan}}">
                                
                               
                                <option >{{$pekerjaan->ruas_jalan}}</option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Lokasi</label>
                        <div class="col-md-10">
                            <input name="lokasi" type="text" class="form-control" required value="{{$pekerjaan->lokasi}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Koordinat X</label>
                        <div class="col-md-10">
                            <input name="lat" type="text" class="form-control formatLatLong" required value="{{$pekerjaan->lat}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Koordinat Y</label>
                        <div class="col-md-10">
                            <input name="lng" type="text" class="form-control formatLatLong" value="{{$pekerjaan->lng}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Panjang (meter)</label>
                        <div class="col-md-10">
                            <input name="panjang" type="text" class="form-control formatRibuan" required value="{{$pekerjaan->panjang}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Jumlah Pekerja</label>
                        <div class="col-md-10">
                            <input name="jumlah_pekerja" type="text" class="form-control formatRibuan" required value="{{$pekerjaan->jumlah_pekerja}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Alat yang Digunakan</label>
                        <div class="col-md-10">
                            <input name="peralatan" type="text" class="form-control" required value="{{$pekerjaan->peralatan}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Foto Dokumentasi (0%)</label>
                        <div class="col-md-9">
                            <img style="max-height: 400px;" class="img-thumbnail rounded mx-auto d-block" src="{{ url('storage/pekerjaan/'.$pekerjaan->foto_awal) }}" alt="">
                        </div>
                        
                    </div><div class="form-group row">
                        <label class="col-md-3 col-form-label">Foto Dokumentasi (50%)</label>
                        <div class="col-md-9">
                            <img style="max-height: 400px;" class="img-thumbnail rounded mx-auto d-block" src="{{ url('storage/pekerjaan/'.$pekerjaan->foto_sedang) }}" alt="">
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Foto Dokumentasi (100%)</label>
                        <div class="col-md-9">
                            <img style="max-height: 400px;" class="img-thumbnail rounded mx-auto d-block" src="{{ url('storage/pekerjaan/'.$pekerjaan->foto_akhir) }}" alt="">
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Video Dokumentasi</label>
                        <div class="col-md-9">
                            <video  style="max-height: 400px;" controls class="img-thumbnail rounded mx-auto d-block">
                                <source src="{{ url('storage/pekerjaan/'.$pekerjaan->video) }}" type="video/mp4" />
                            </video>
                        </div>
                        
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
