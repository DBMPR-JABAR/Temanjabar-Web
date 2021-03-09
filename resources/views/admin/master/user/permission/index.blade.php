@extends('admin.layout.index')

@section('title')Permission @endsection
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
                <h4>Permission </h4>

            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class=" breadcrumb breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{url('admin')}}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Permission</a> </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('page-body')

    <div class="row">
        <div class="col-xl-7 col-md-7">
            <div class="card">
                <div class="card-header">
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            {{-- <li><i class="feather icon-maximize full-card"></i></li> --}}
                            <li><i class="feather icon-minus minimize-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    {{-- <a href="{{ route('createRoleAccess') }}" class="btn btn-mat btn-primary mb-3">Tambah</a> --}}
                    <div class="dt-responsive table-responsive">
                        <table id="dttable" class="table table-striped table-bordered able-responsive">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th width="50%">Nama</th>
                                    {{-- <th>Menu</th> --}}
                                    <th>Menu</th>
                                    <th>Aksi</th>

                                </tr>
                            </thead>
                            <tbody id="bodyJembatan">
                                
                                @foreach ($permission as $no => $data)
                                    <tr>
                                        <td>{{++$no}}</td>
                                        <td>{{$data->nama}}</td>
                                        {{-- <td>{{$data['permissions']}}</td> --}}
                                        <td>{{$data->menu_id}}</td>
                                        <td>
                                                <a type='button' href='{{ route('editRoleAccess', $data->id) }}'  class='btn btn-primary btn-mini waves-effect waves-light'><i class='icofont icofont-check-circled'></i>Edit</a>
                                                {{-- <a type='button' href='#editModal'  data-toggle='modal' data-id='{{$data->id}}' data-uptd_access='{{$uptd_access[$i]}}'  class='btn btn-primary btn-mini waves-effect waves-light'><i class='icofont icofont-check-circled'></i>Edit</a> --}}
                                                @if(Auth::user() && Auth::user()->id == $data->created_by)
                                                    <a type='button' href='#delModal'  data-toggle='modal' data-id='{{$data->id}}' class='btn btn-primary btn-mini waves-effect waves-light'><i class='icofont icofont-check-circled'></i>Hapus</a><br/>
                                                @endif
                                        </td>
                                    </tr>
                                   
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-5 col-md-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Menu</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            {{-- <li><i class="feather icon-maximize full-card"></i></li> --}}
                            <li><i class="feather icon-minus minimize-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <a data-toggle="modal" href="#addModal1" class="btn btn-mat btn-primary mb-3">Tambah</a>
                    
                    <div class="dt-responsive table-responsive">
                        <table id="dttable1" class="table table-striped table-bordered able-responsive">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    {{-- <th>Menu</th> --}}
                                    <th>Aksi</th>

                                </tr>
                            </thead>
                            <tbody id="bodyJembatan">
                                
                                @foreach ($menu as $no => $data)

                                    <tr>
                                        <td>{{++$no}}</td>
                                        <td>{{$data->nama}}</td>
                                       
                                        <td>
                                            <a type='button' href='#editModal1' data-toggle='modal' data-id='{{ $data->id }}' class='btn btn-warning btn-mini waves-effect waves-light'><i class='icofont icofont-edit'></i></a>
                                                {{-- <a type='button' href='#editModal'  data-toggle='modal' data-id='{{$data->id}}' data-uptd_access='{{$uptd_access[$i]}}'  class='btn btn-primary btn-mini waves-effect waves-light'><i class='icofont icofont-check-circled'></i>Edit</a> --}}
                                            <a type='button' href='#delModal1'  data-toggle='modal' data-id='{{$data->id}}' class='btn btn-danger btn-mini waves-effect waves-light'><i class='icofont icofont-delete'></i></a><br/>
                                                
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
        <div class="modal fade" id="addModal1" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                    <form action="{{ route('createMenu') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Menu</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body p-5">

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Nama Menu</label>
                                <div class="col-md-9">
                                    <input type="text" name="nama" placeholder="Masukan Nama Menu" class="form-control" required></input>
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
        <div class="modal fade" id="editModal1" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                    <form action="{{ route('updateMenu') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Menu</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body p-5">
                            <input type="text" name="id" id="id" class="form-control" hidden></input>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Nama Menu</label>
                                <div class="col-md-9">
                                    <input type="text" name="nama" id="nama" placeholder="Masukan Nama Menu" class="form-control" required></input>
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
        <div class="modal fade" id="delModal1" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title">Hapus Menu</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p>Apakah anda yakin ingin menghapus data ini?</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
                        <a id="delHref1" href="" class="btn btn-danger waves-effect waves-light ">Hapus</a>
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
<script type="text/javascript" src="{{ asset('assets/vendor/chosen_v1.8.7/chosen.jquery.js') }}" type="text/javascript"></script>

<script>
    $(document).ready(function() {
        $(".chosen-select").chosen( { width: '100%' } );
        $(".chosen-jenis-instruksi").chosen( { width: '100%' } );
        $("#dttable").DataTable();
        $("#dttable1").DataTable();

        $('#delModal').on('show.bs.modal', function(event) {
            const link = $(event.relatedTarget);
            const id = link.data('id');
            console.log(id);
            const url = `{{ url('admin/master-data/user/role-akses/delete') }}/` + id;
            console.log(url);
            const modal = $(this);
            modal.find('.modal-footer #delHref').attr('href', url);
        });
        $('#editModal1').on('show.bs.modal', function(event) {
            
            const link = $(event.relatedTarget);
            const id = link.data('id');
            console.log(id);
            const baseUrl = `{{ url('admin/master-data/user/edit-menu') }}/` + id;
          
            $.get(baseUrl, {
                    id: id
                },
                function(response) {
                    
                    $('#id').val(response.menu[0].id);
                    $('#nama').val(response.menu[0].nama);
                    

                });

        });
        $('#delModal1').on('show.bs.modal', function(event) {
            const link = $(event.relatedTarget);
            const id = link.data('id');
            console.log(id);
            const url = `{{ url('admin/master-data/user/destroy-menu') }}/` + id;
            console.log(url);
            const modal = $(this);
            modal.find('.modal-footer #delHref1').attr('href', url);
        });

    });
</script>
@endsection
