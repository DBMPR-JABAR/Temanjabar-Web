@extends('admin.t_index')

@section('title') Edit Jembatan @endsection

@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Edit Jembatan</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin') }}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('getMasterJembatan') }}">Jembatan</a> </li>
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
                <h5>Edit Data Jembatan</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">

                <form action="{{ route('updateJembatan') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$jembatan->id}}">

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Id Jembatan</label>
                        <div class="col-md-10">
                            <input name="id_jembatan" type="text" class="form-control" value="{{$jembatan->id_jembatan}}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Nama Jembatan</label>
                        <div class="col-md-10">
                            <input name="nama_jembatan" type="text" class="form-control" value="{{$jembatan->nama_jembatan}}" required>
                        </div>
                    </div>

                    @if(Auth::user()->internalRole->uptd)
                    <input type="hidden" id="uptd" name="uptd" value="{{$jembatan->uptd}}">
                    @else
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">UPTD</label>
                        <div class="col-md-10">
                            <select class="form-control" id="uptd" name="uptd" onchange="ubahOption()" required>
                                <option value="{{$jembatan->slug}}">{{$jembatan->uptd}}</option>
                                <option disabled></option>
                                @foreach ($uptd as $data)
                                <option value="{{$data->slug}}" @if($data->slug==$jembatan->uptd) selected @endif>{{$data->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Ruas Jalan</label>
                        <div class="col-md-10">
                            <select id="ruas_jalan" name="ruas_jalan" class="form-control" required>
                                <option value="{{$jembatan->ruas_jalan}}">{{$jembatan->ruas_jalan}}</option>
                                <option disabled></option>
                                @foreach ($ruasJalan as $data)
                                <option value="{{$data->nama_ruas_jalan}}">{{$data->nama_ruas_jalan}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">SUP</label>
                        <div class="col-md-10">
                            <select class="form-control" id="sup" name="sup" required>
                                <option value="{{$jembatan->sup}}">{{$jembatan->sup}}</option>
                                <option disabled></option>
                                @foreach ($sup as $data)
                                <option value="{{$data->name}}">{{$data->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Lokasi</label>
                        <div class="col-md-10">
                            <input name="lokasi" type="text" class="form-control" required value="{{$jembatan->lokasi}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Panjang (meter)</label>
                        <div class="col-md-10">
                            <input name="panjang" type="text" class="form-control formatRibuan" required value="{{$jembatan->panjang}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Lebar (meter)</label>
                        <div class="col-md-10">
                            <input name="lebar" type="text" class="form-control formatRibuan" required value="{{$jembatan->lebar}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Jumlah Bentang</label>
                        <div class="col-md-10">
                            <input name="jumlah_bentang" type="number" class="form-control" step="any" value="{{$jembatan->jumlah_bentang}}" readonly>
                            <div class="form-group row w-100 mx-auto mb-0">
                                <div class="col-md-2">
                                    <p class="my-1 p-1">Bentang</p>
                                </div>
                                <div class="col-md-5">
                                    <p class="my-1 p-1">Panjang (meter)</p>
                                </div>
                                <div class="col-md-5">
                                    <p class="my-1 p-1">Tipe Bangunan Atas</p>
                                </div>
                                <?php for ($i = 0; $i < $jembatan->jumlah_bentang; $i++) { ?>
                                    <div class="form-group row w-100 mx-auto">
                                        <div class="col-md-2">
                                            <input type="number" class="form-control h-100" value="{{$i+1}}" readonly>
                                            <input name="idBentang{{$i}}" type="number" class="form-control h-100" value="{{@$dataBentang[$i]->id}}" hidden>
                                        </div>
                                        <div class="col-md-5">
                                            <input name="panjangBentang{{$i}}" type="number" class="form-control h-100" step="any" value="{{@$dataBentang[$i]->panjang}}"></div>
                                        <div class="col-md-5">
                                            <select class="form-control" name="tipe{{$i}}">
                                                @foreach ($tipe as $data)
                                                @if(@$dataBentang[$i]->tipe_bangunan_atas_id == $data->id)
                                                <option value="{{$data->id}}" selected>{{$data->nama}}</option>
                                                @else
                                                <option value="{{$data->id}}">{{$data->nama}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Koordinat X (Lat)</label>
                        <div class="col-md-10">
                            <input name="lat" type="text" class="form-control formatLatLong" required value="{{$jembatan->lat}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Koordinat Y (Lon)</label>
                        <div class="col-md-10">
                            <input name="lng" type="text" class="form-control formatLatLong" required value="{{$jembatan->lng}}">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Keterangan</label>
                        <div class="col-md-10">
                            <input name="ket" type="text" class="form-control" required value="{{$jembatan->ket}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Foto Jembatan</label>
                        <div class="col-md-6">
                            <input name="foto" type="file" class="form-control">
                            <small class="form-text text-muted">Kosongkan jika tidak akan merubah foto jembatan</small>
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

        //untuk select SUP
        val = document.getElementById("uptd").value
        id = parseInt(val.slice(val.length - 1))

        url = "{{ url('admin/master-data/ruas-jalan/getSUP') }}"
        id_select = '#sup'
        text = 'Pilih SUP'
        option = 'name'

        setDataSelect(id, url, id_select, text, option, option)

        //untuk select Ruas
        url = "{{ url('admin/input-data/kondisi-jalan/getRuasJalan') }}"
        id_select = '#ruas_jalan'
        text = 'Pilih Ruas Jalan'
        option = 'nama_ruas_jalan'

        setDataSelect(id, url, id_select, text, option, option)
    }
</script>
@endsection