@extends('admin.t_index')

@section('title') Admin Dashboard @endsection

@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Ruas Jalan</h4>
                <span>Seluruh Ruas Jalan yang ada di naungan DBMPR Jabar</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin') }}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('getMasterRuasJalan') }}">Ruas Jalan</a> </li>
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
                <h5>Edit Data Ruas Jalan</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block pl-5 pr-5 pb-5">

                <form action="{{ route('updateMasterRuasJalan') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$ruasJalan->id}}">

                    <!-- <div class="form-group row">
                        <label class="col-md-2 col-form-label">Id Ruas Jalan</label>
                        <div class="col-md-10">
                            <input name="id_ruas_jalan" type="text" class="form-control" required value="{{$ruasJalan->id_ruas_jalan}}">
                        </div>
                    </div> -->

                    <div class=" form-group row">
                        <label class="col-md-2 col-form-label">Nama Ruas Jalan</label>
                        <div class="col-md-10">
                            <input name="nama_ruas_jalan" type="text" class="form-control" required value="{{$ruasJalan->nama_ruas_jalan}}">
                        </div>
                    </div>

                    <?php

                    use Illuminate\Support\Facades\Auth;

                    if (Auth::user()->internalRole->uptd) {
                        $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd); ?>
                        <input name="uptd_id" type="number" class="form-control" value="{{$uptd_id}}" hidden>
                    <?php } else { ?>
                        <div class=" form-group row">
                            <label class="col-md-2 col-form-label">UPTD</label>
                            <div class="col-md-10">
                                <select class="form-control select2" id="uptd_id" name="uptd_id" style="min-width: 100%;" onchange="ubahDataSUP()">
                                    @foreach ($uptd as $uptdData)
                                    @if($ruasJalan->uptd_id == $uptdData->id)
                                    <option value="<?php echo $uptdData->id; ?>" selected><?php echo $uptdData->nama; ?></option>
                                    @else
                                    <option value="<?php echo $uptdData->id; ?>"><?php echo $uptdData->nama; ?></option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    <?php    } ?>

                    <div class=" form-group row">
                        <label class="col-md-2 col-form-label">SUP</label>
                        <div class="col-md-10">
                            <select class="form-control select2" id="sup" name="sup" style="min-width: 100%;">
                                <!-- <option value="" selected>- Event Name -</option> -->

                                @foreach ($sup as $supData)
                                @if($supData->id == $ruasJalan->sup)
                                <option value="<?php echo $supData->id; ?>" selected><?php echo $supData->name; ?></option>
                                @else
                                <option value="<?php echo $supData->id; ?>"><?php echo $supData->name; ?></option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class=" form-group row">
                        <label class="col-md-2 col-form-label">Lokasi</label>
                        <div class="col-md-10">
                            <input name="lokasi" type="text" class="form-control" required value="{{$ruasJalan->lokasi}}">
                        </div>
                    </div>

                    <div class=" form-group row">
                        <label class="col-md-2 col-form-label">Panjang (meter)</label>
                        <div class="col-md-10">
                            <input name="panjang" type="text" class="form-control formatRibuan" required value="{{$ruasJalan->panjang}}">
                        </div>
                    </div>

                    <div class=" form-group row">
                        <label class="col-md-2 col-form-label">Status Awal</label>
                        <div class="col-md-10">
                            <input name="sta_awal" type="number" step="0.01" class="form-control" required value="{{$ruasJalan->sta_awal}}">
                        </div>
                    </div>

                    <div class=" form-group row">
                        <label class="col-md-2 col-form-label">Status Akhir</label>
                        <div class="col-md-10">
                            <input name="sta_akhir" type="number" step="0.01" class="form-control" required value="{{$ruasJalan->sta_akhir}}">
                        </div>
                    </div>

                    <div class=" form-group row">
                        <label class="col-md-2 col-form-label">Lat Awal</label>
                        <div class="col-md-10">
                            <input name="lat_awal" type="text" class="form-control" required value="{{$ruasJalan->lat_awal}}">
                        </div>
                    </div>

                    <div class=" form-group row">
                        <label class="col-md-2 col-form-label">Long Awal</label>
                        <div class="col-md-10">
                            <input name="long_awal" type="text" class="form-control" required value="{{$ruasJalan->long_awal}}">
                        </div>
                    </div>

                    <div class=" form-group row">
                        <label class="col-md-2 col-form-label">Lat Akhir</label>
                        <div class="col-md-10">
                            <input name="lat_akhir" type="text" class="form-control" required value="{{$ruasJalan->lat_akhir}}">
                        </div>
                    </div>

                    <div class=" form-group row">
                        <label class="col-md-2 col-form-label">Long Akhir</label>
                        <div class="col-md-10">
                            <input name="long_akhir" type="text" class="form-control" required value="{{$ruasJalan->long_akhir}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Kabupaten Kota</label>
                        <div class="col-md-10">
                            <input name="kab_kota" type="text" class="form-control" required value="{{$ruasJalan->kab_kota}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Kode SPPJJ</label>
                        <div class="col-md-10">
                            <input name="kd_sppjj" type="text" class="form-control" required value="{{$ruasJalan->kd_sppjj}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Nama SPPJJ</label>
                        <div class="col-md-10">
                            <input name="nm_sppjj" type="text" class="form-control" required value="{{$ruasJalan->nm_sppjj}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Lat ctr</label>
                        <div class="col-md-10">
                            <input name="lat_ctr" type="text" class="form-control formatLatLong" required value="{{$ruasJalan->lat_ctr}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Long ctr</label>
                        <div class="col-md-10">
                            <input name="long_ctr" type="text" class="form-control formatLatLong" required value="{{$ruasJalan->long_ctr}}">
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
<script src="{{ asset('assets/vendor/jquery/js/jquery.mask.js') }}"></script>
<script>
    // Format mata uang.
    $('.formatRibuan').mask('000.000.000.000.000', {
        reverse: true
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