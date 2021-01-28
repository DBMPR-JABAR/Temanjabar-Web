@extends('admin.t_index')

@section('title') Admin Dashboard @endsection

@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Data Rawan Bencana</h4>
                <span>Seluruh Data Rawan Bencana di naungan DBMPR Jabar</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin') }}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('getDataBencana') }}">Data Rawan Bencana</a> </li>
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
                <h5>Edit Data Rawan Bencana</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">

                <form action="{{ route('updateDataBencana',$rawan->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- <input type="hidden" name="uptd_id" value="{{$rawan->uptd_id}}"> -->
                    <input type="hidden" name="id" value="{{$rawan->id}}">

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">No Ruas</label>
                        <div class="col-md-10">
                            <input name="no_ruas" type="text" class="form-control" value="{{$rawan->no_ruas}}">
                        </div>
                    </div>

                    @if (Auth::user()->internalRole->uptd)
                    <input type="hidden" id="uptd" name="uptd_id" value="{{$rawan->uptd_id}}">
                    @else
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Uptd</label>
                        <div class="col-md-10">
                            <select class="form-control" id="uptd" name="uptd_id" onchange="ubahOption()">
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
                            <select id="ruas_jalan" name="ruas_jalan" class="form-control">
                                <option value="{{$rawan->ruas_jalan}}">{{$rawan->ruas_jalan}}</option>>
                                <option></option>
                                @foreach ($ruas as $data)
                                <option value="{{$data->nama_ruas_jalan}}">{{$data->nama_ruas_jalan}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Lokasi</label>
                        <div class="col-md-10">
                            <input name="lokasi" type="text" class="form-control" value="{{$rawan->lokasi}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Daerah</label>
                        <div class="col-md-10">
                            <input name="daerah" type="text" class="form-control" value="{{$rawan->daerah}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Lat</label>
                        <div class="col-md-10">
                            <input name="lat" type="text" class="form-control" value="{{$rawan->lat}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Long</label>
                        <div class="col-md-10">
                            <input name="long" type="text" class="form-control" value="{{$rawan->long}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Foto</label>
                        <div class="col-md-10">
                            <input name="foto" type="file" class="form-control" value="{{$rawan->foto}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">SUP</label>
                        <div class="col-md-10">
                            <select id="sup" name="SUP" class="form-control">
                                <option value="{{$rawan->sup}}" class="sup">{{$rawan->sup}}</option>>
                                <option class="sup"></option>
                                @foreach ($sup as $data)
                                <option value="{{$data->name}}" class="sup">{{$data->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <label class="col-md-2 col-form-label">Status</label>
                        <div class="col-md-10">
                            <select class="form-control" name="status">
                                <option value="P">P</option>
                                <option value="N">N</option>
                            </select>
                        </div>
                    </div> --}}

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Keterangan</label>
                        <div class="col-md-10">
                            <textarea name="keterangan" rows="3" cols="3" class="form-control" placeholder="Masukkan Keterangan">{{$rawan->keterangan}}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                            <label class="col-md-2 col-form-label">Icon</label>
                            <div class="col-md-10">
                                <select name="icon_id" class="form-control" onchange="getURL()" id="icon" >
                                    @foreach($icon as $data)
                                        <option value="{{ $data->id }}">{{ $data->icon_name }}</option>
                                    @endforeach
                                </select>
                                @if($icon_curr == null)
                                <img class="img-fluid mt-2" style="max-width: 100px" src="#" alt="" srcset="" id="icon-img">
                                @endif
                                @if($icon_curr != null)
                                <img class="img-fluid mt-2" style="max-width: 100px" src="{{ $icon_curr->icon_image }}" alt="" srcset="" id="icon-img">
                                @endif
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
<script>
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
        });
    }
    function getURL(){
        var id = document.getElementById("icon").value;
        const baseUrl = `{{ url('admin/master-data/rawanbencana/getURL') }}/` + id;
        $.get(baseUrl, { id: id },
            function(response){
                console.log(response);
                $('#icon-img').attr('src',response.icon[0].icon_image);
        });
    }
</script>
@endsection
