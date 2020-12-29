@extends('admin.t_index')

@section('title')CCTV @endsection
@section('head')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables.net/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables.net/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/data-table/extensions/responsive/css/responsive.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/chosen_v1.8.7/chosen.css') }}">
<link rel="stylesheet" href="https://js.arcgis.com/4.17/esri/themes/light/main.css">

<style>
.chosen-container.chosen-container-single {
    width: 300px !important; /* or any value that fits your needs */
}

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
                <h4>CCTV </h4>
                
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{url('admin')}}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">CCTV</a> </li>
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
                                <th>Lokasi</th>
                                <th>Lat</th>
                                <th>Long</th>
                                <th>Url</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Enable Vehicle Counting</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="bodyJembatan">
                             @foreach ($cctv as $data)
                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$data->lokasi}}</td>
                                    <td>{{$data->lat}}</td>
                                    <td>{{$data->long}}</td>
                                    <td>{{$data->url}}</td>
                                    <td>{{$data->description}}</td>
                                    <td>{{$data->category}}</td>
                                    <td>{{$data->status}}</td>
                                    <td>{{$data->enable_vehicle_counting}}</td>
                                    <td> 
                                            <a type='button' href="{{ route('detailDataCCTV',$data->id ) }}"  class='btn btn-primary btn-mini waves-effect waves-light'><i class='icofont icofont-check-circled'></i>Rincian</a>
                                            <a type='button' href='#editModal'  data-toggle='modal' data-id='{{$data->id}}'  class='btn btn-primary btn-mini waves-effect waves-light'><i class='icofont icofont-check-circled'></i>Edit</a> 
                                            <a type='button' href='#delModal'  data-toggle='modal' data-id='{{$data->id}}'     class='btn btn-primary btn-mini waves-effect waves-light'><i class='icofont icofont-check-circled'></i>Hapus</a><br/>     
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
                    <h4 class="modal-title">Hapus Data CCTV</h4>
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

    <div class="modal fade" id="acceptModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Disposisi Diterima?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>Apakah anda yakin menerima disposisi ini?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
                    <a id="delHref" href="" class="btn btn-danger waves-effect waves-light ">Terima</a>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="disposisiModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Disposisi Diterima?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>Apakah anda yakin menerima disposisi ini?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
                    <a id="delHref" href="" class="btn btn-danger waves-effect waves-light ">Terima</a>
                </div>

            </div>
        </div>
    </div>



</div>

<div class="modal-only">
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <form action="{{route('createCCTV')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah CCTV</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body p-5">

                    <div class="form-group row">
                            <label class="col-md-3 col-form-label">Lokasi</label>
                            <div class="col-md-9">
                                <input type="text" name="lokasi" class="form-control"></input>
                            </div>
                    </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Lat</label>
                            <div class="col-md-9">
                                <input type="text" name="lat" class="form-control"></input>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Long</label>
                            <div class="col-md-9">
                                <input type="text" name="long" class="form-control"></input>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Url</label>
                            <div class="col-md-9">
                                <input type="text" name="url" class="form-control"></input>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Description</label>
                            <div class="col-md-9">
                                <textarea name="description" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Category</label>
                            <div class="col-md-9">
                                <input type="text" name="category" class="form-control"></input>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Status</label>
                            <div class="col-md-9">
                                <input type="text" name="status" class="form-control"></input>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Enable Vehicle Counting</label>
                            <div class="col-md-9">
                                <select name="enable_vehicle_counting" class="form-control">
                                    <option value="0" >0</option>
                                    <option value="1" >1</option>
                                </select>
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

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <form action="{{route('updateDataCCTV')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h4 class="modal-title">Edit CCTV</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body p-5">
                    <input type="text" name="id" id="id" class="form-control" hidden></input>
                    <div class="form-group row">
                            <label class="col-md-3 col-form-label">Lokasi</label>
                            <div class="col-md-9">
                                <input type="text" name="lokasi" id="lokasi" class="form-control"></input>
                            </div>
                    </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Lat</label>
                            <div class="col-md-9">
                                <input type="text" name="lat" id="lat" class="form-control"></input>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Long</label>
                            <div class="col-md-9">
                                <input type="text" name="long" id="long" class="form-control"></input>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Url</label>
                            <div class="col-md-9">
                                <input type="text" name="url" id="url" class="form-control"></input>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Description</label>
                            <div class="col-md-9">
                                <textarea name="description" id="description" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Category</label>
                            <div class="col-md-9">
                                <input type="text" name="category" id="category" class="form-control"></input>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Status</label>
                            <div class="col-md-9">
                                <input type="text" name="status" id="status" class="form-control"></input>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Enable Vehicle Counting</label>
                            <div class="col-md-9">
                                <select name="enable_vehicle_counting" id="enable_vehicle_counting" class="form-control">
                                    <option value="0" id="e_1">0</option>
                                    <option value="1" id="e_2">1</option>
                                </select>
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
@endsection
@section('script')
<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net/js/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/chosen_v1.8.7/chosen.jquery.js') }}" type="text/javascript"></script>

<script>
    $(document).ready(function() {
        $(".chosen-select").chosen( { width: '100%' } );
        $(".chosen-jenis-instruksi").chosen( { width: '100%' } );
        $("#dttable").DataTable();
        $('#delModal').on('show.bs.modal', function(event) {
            const link = $(event.relatedTarget);
            const id = link.data('id');
            console.log(id);
            const url = `{{ url('admin/master-data/CCTV/delete') }}/` + id;
            console.log(url);
            const modal = $(this);
            modal.find('.modal-footer #delHref').attr('href', url);
        });

        $('#editModal').on('show.bs.modal', function(event) {
            const link = $(event.relatedTarget);
            const id = link.data('id');
            console.log(id);
            const baseUrl = `{{ url('admin/master-data/CCTV/edit') }}/` + id;
            $.get(baseUrl, { id: id },
                function(response){
                    $('#id').val(response.cctv[0].id);
                    $('#lokasi').val(response.cctv[0].lokasi);
                    $('#lat').val(response.cctv[0].lat);
                    $('#long').val(response.cctv[0].long);
                    $('#url').val(response.cctv[0].url);
                    $('#description').val(response.cctv[0].description);
                    $('#category').val(response.cctv[0].category);
                    $('#status').val(response.cctv[0].status);
                    $('#e_1').removeAttr("selected");
                    $('#e_2').removeAttr("selected");
                    for(var i=1;i<=2;i++){
                        if($('#e_'+i).val() == response.cctv[0].enable_vehicle_counting){
                            $('#e_'+i).attr("selected","selected");
                        }
                    }
                });
            });


    });
</script>
@endsection