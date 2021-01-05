@extends('admin.t_index')

@section('title') Edit Jembatan @endsection

@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Edit Foto Jembatan</h4>
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
                <li class="breadcrumb-item"><a href="#">Edit Foto</a> </li>
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
                <h5>Edit Foto Jembatan</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">

                <form action="{{ route('updatePhotoJembatan') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$jembatan->id}}">

                   
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Foto Jembatan</label><br>    
                        <small class="form-text text-muted">Hapus semua foto jika tidak akan merubah foto jembatan</small>
                        </div>
                        @foreach($foto as $i => $data)
                        <div id="inputFormRow">
                           <div class="input-group">
                                <input type="hidden" name="id_j[]" class="form-control m-input" value="{{$data->id}}" required>
                                <input type="text" name="nama[]" class="form-control m-input" value="{{$data->nama}}" placeholder="Judul Foto" autocomplete="off" required>
                                <input type="file" name="foto[]" class="form-control m-input" value="{{$data->foto}}" accept="image/*"><span><?php if($data->foto!=''){ echo '<label class="label label-success">Ada Foto</label>';}else{echo '<label class="label label-danger">Kosong</label>';}?></span>
                               <!--  <div class="input-group-append">                
                                    <button id="removeRow" type="button" class="btn btn-danger">Hapus</button>
                                </div> -->
                            </div>
                        </div>
                         @endforeach

                        <div id="newRow"></div>
                        <button id="addRow" type="button" class="btn btn-info">Tambah Foto Jembatan</button>

                    <div class="modal-footer">
                    <button type="submit" class="btn btn-mat btn-success">Simpan Perubahan</button>
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

    $("#addRow").click(function () {
            var html = '';
        html += '<div id="inputFormRow">';
        html += '<div class="input-group">';
        html += '<input type="hidden" name="id_j[]" class="form-control m-input">';
        html += '<input type="text" name="nama[]" class="form-control m-input" placeholder="Enter title" autocomplete="off" required>';
        html += '<input type="file" name="foto[]" class="form-control m-input" accept="image/*" required>';
        html += '<div class="input-group-append">';
        html += '<button id="removeRow" type="button" class="btn btn-danger">Hapus</button>';
        html += '</div>';
        html += '</div>';
 

        $('#newRow').append(html);
    });

    // remove row
    $(document).on('click', '#removeRow', function () {
        $(this).closest('#inputFormRow').remove();
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