@extends('admin.t_index')

@section('title')Grant Access Role Aplikasi @endsection
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
                <h4>Grant Access Role Aplikasi </h4>

            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{url('admin')}}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Grant Access Role Aplikasi</a> </li>
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
                                <th>User Role</th>
                                <th>Menu</th>
                                <th>Role Access</th>
                                <th>UPTD Access</th>
                                <th>Aksi</th>

                            </tr>
                        </thead>
                        <tbody id="bodyJembatan">
                            @php
                                $i=0;
                            @endphp
                             @foreach ($user_role_list as $data)

                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$data->role}}</td>
                                    <td>{{$data->menu_user}}</td>
                                    <td>{{$role_access[$i]}}</td>
                                    <td>{{$uptd_access[$i]}}</td>
                                    <td>
                                            <a type='button' href="{{ route('detailRoleAkses', $data->role_id) }}"  class='btn btn-primary btn-mini waves-effect waves-light'><i class='icofont icofont-check-circled'></i>Rincian</a>
                                            <a type='button' href='#editModal'  data-toggle='modal' data-id='{{$data->role_id}}'  class='btn btn-primary btn-mini waves-effect waves-light'><i class='icofont icofont-check-circled'></i>Edit</a>
                                            <a type='button' href='#delModal'  data-toggle='modal' data-id='{{$data->role_id}}'     class='btn btn-primary btn-mini waves-effect waves-light'><i class='icofont icofont-check-circled'></i>Hapus</a><br/>
                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
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
                    <h4 class="modal-title">Hapus Data Role Akses</h4>
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

                <form action="{{route('createRoleAkses')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Role Access</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body p-5">

                    <div class="form-group row">
                            <label class="col-md-3 col-form-label">User Role</label>
                            <div class="col-md-9">

                                <select  name="user_role" tabindex="4" required>
                                    @foreach($user_role as $data)
                                            <option value="{{$data->role}}">{{$data->role}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">menu</label>
                            <div class="col-md-9">
                                <select data-placeholder="Menu..." class="chosen-select" multiple  name="menu[]" id="" tabindex="4" required tabindex="4">
                                    @foreach($menu as $data)
                                            <option value="{{$data->menu}}">{{$data->menu}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Role Access</label>
                            <div class="col-md-9">
                            <select data-placeholder="User Role..." class="chosen-select" multiple  name="role_access[]" tabindex="4">
                                 <option value="Create" >Create</option>
                                 <option value="View">View</option>
                                 <option value="Update">Update</option>
                                 <option value="Delete">Delete</option>
                            </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">UPTD Access</label>
                            <div class="col-md-9">
                            <select data-placeholder="UPTD Access..." class="chosen-select" multiple name="uptd_access[]" tabindex="4">
                                    <option value="UPTD 1">UPTD 1</option>
                                    <option value="UPTD 2">UPTD 2</option>
                                    <option value="UPTD 3">UPTD 3</option>
                                    <option value="UPTD 4">UPTD 4</option>
                                    <option value="UPTD 5">UPTD 5</option>
                                    <option value="UPTD 6">UPTD 6</option>

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

                <form action="{{route('updateDataRoleAkses')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Role Access</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body p-5">

                    <div class="form-group row">
                            <input name="id" id="id" class="form-control" hidden></input>
                            <label class="col-md-3 col-form-label">User Role</label>
                            <div class="col-md-9">

                                <select  name="user_role" id="select_user_role" tabindex="4" required>
                                    @foreach($user_role as $data)
                                            <option value="{{$data->role}}" id="edit_user_role_{{$loop->index + 1}}">{{$data->role}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">menu</label>
                            <div class="col-md-9">
                                <select data-placeholder="Menu..." class="chosen-select" multiple  name="menu[]" id="#edit_select_menu" tabindex="4" required tabindex="4">
                                    @foreach($menu as $data)
                                            <option value="{{$data->menu}}" id="menu_{{$loop->index + 1}}">{{$data->menu}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Role Access</label>
                            <div class="col-md-9">
                            <select data-placeholder="Role Access..." class="chosen-select" multiple  name="role_access[]" id="edit_role_access" tabindex="4">
                                 <option value="Create" id="user_role_1" >Create</option>
                                 <option value="View" id="user_role_2">View</option>
                                 <option value="Update" id="user_role_3">Update</option>
                                 <option value="Delete" id="user_role_4">Delete</option>
                            </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">UPTD Access</label>
                            <div class="col-md-9">
                            <select data-placeholder="UPTD Access..." class="chosen-select" multiple name="uptd_access[]" id="edit_uptd_access" tabindex="4">
                                    <option value="UPTD 1" id="uptd_1">UPTD 1</option>
                                    <option value="UPTD 2" id="uptd_2">UPTD 2</option>
                                    <option value="UPTD 3" id="uptd_3">UPTD 3</option>
                                    <option value="UPTD 4" id="uptd_4">UPTD 4</option>
                                    <option value="UPTD 5" id="uptd_5">UPTD 5</option>
                                    <option value="UPTD 6" id="uptd_6">UPTD 6</option>

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

    <div class="modal fade" id="delModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Hapus Data Disposisi</h4>
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
    </li>
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
            const url = `{{ url('admin/master-data/user/role-akses/delete') }}/` + id;
            console.log(url);
            const modal = $(this);
            modal.find('.modal-footer #delHref').attr('href', url);
        });

        $('#editModal').on('show.bs.modal', function(event) {
            const link = $(event.relatedTarget);
            const id = link.data('id');
            console.log(id);
            const baseUrl = `{{ url('admin/master-data/user/role-akses/getData') }}/` + id;
            $.get(baseUrl, { id: id },
                function(response){
                        console.log(response);
                        $('#id').val(id);
                        for(var i=1; i<=$('#select_user_role').children('option').length;i++){
                            if($('#edit_user_role_'+i).val() == response.user_role_list[0].role){
                                $('#edit_user_role_'+i).attr("selected","selected");
                            }
                        }
                        for(var i=1; i<=$('#edit_select_menu').children('option').length;i++){
                            for(var j=0; j<response.user_role.length;j++){
                                if($('#menu_'+i).val() == response.user_role[j].menu){
                                    $('#menu_'+i).attr("selected","selected");
                                }
                            }
                        }
                        for(var i=1; i<=$('#edit_role_access').children('option').length;i++){
                            for(var j=0; j<response.role_access.length;j++){
                                if($('#user_role_'+i).val() == response.role_access[j].menu){
                                    $('#user_role_'+i).attr("selected","selected");
                                }
                            }
                        }
                        for(var i=1; i<=$('#edit_role_access').children('option').length;i++){
                            for(var j=0; j<response.role_access.length;j++){
                                if($('#user_role_'+i).val() == response.role_access[j].menu){
                                    $('#user_role_'+i).attr("selected","selected");
                                }
                            }
                        }
                        for(var i=1; i<=$('#edit_uptd_access').children('option').length;i++){
                            for(var j=0; j<response.uptd_access.length;j++){
                                if($('#uptd_'+i).val() == response.uptd_access[j].menu){
                                    $('#uptd'+i).attr("selected","selected");
                                }
                            }
                        }
            });
        });

    });
</script>
@endsection
