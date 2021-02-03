@extends('admin.t_index')

@section('title')Role Akses @endsection
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
                    <h4>Profil </h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{url('admin')}}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Profil</a> </li>
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
                    {{-- <a href="{{ route('createRoleAccess') }}" class="btn btn-mat btn-primary mb-3">Tambah</a> --}}
                    <div class="dt-responsive table-responsive">
                        {{-- Content here --}}
                        <form action="{{url('admin/user/profile/'.Auth::user()->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="users">
                                                {{-- <tr>
                                                    <td>Nama Depan</td>
                                                    <td>
                                                        <input name="firstName" placeholder="Enter your First name" type="text" value="" class="form-control required">
                                                    </td>
                                                    <td>Nama Belakang</td>
                                                    <td>
                                                        <input name="lastName" placeholder="Enter your First name" type="text" value="" class="form-control required">
                                                    </td>
                                                </tr> --}}
                                                <tr>
                                                    <td >Nama Lengkap</td>
                                                    <td colspan="3">
                                                        <input name="nama" placeholder="Enter your First name" type="text" value="{{ old('nama', $profile->nama) }}" class="form-control required">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>NIP</td>
                                                    <td colspan="3">
                                                        <input name="no_pegawai" placeholder="Enter your First name" type="text" value="{{ old('no_pegawai', $profile->no_pegawai) }}" class="form-control required">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Jabatan</td>
                                                    <td colspan="3">
                                                        <input name="jabatan" placeholder="Enter your Role" type="text" value="" class="form-control "readonly>
                                                        <i style="color :red; font-size: 10px;">Untuk perubahan hubungi admin</i>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal Lahir</td>
                                                    <td >
                                                        <input name="tgl_lahir" placeholder="Enter your First name" type="date" value="{{ old('no_pegawai', $profile->tgl_lahir) }}" class="form-control required">
                                                    </td>
                                                    <td>Jenis Kelamin</td>
                                                    <td>
                                                        <select class="form-control" name="jenis_kelamin" >
                                                            <option>Select</option>
                                                            {{-- <option selected>
                                                                {!! $profile->jenis_kelamin  !!}
                                                            </option> --}}
                                                            <option value="Laki-laki" @if(strpos( 'Laki-laki', $profile->jenis_kelamin ) !== false) selected @endif>Laki-Laki</option>
                                                            <option value="Perempuan" @if(strpos( 'Perempuan', $profile->jenis_kelamin ) !== false) selected @endif>Perempuan</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Phone Number</td>
                                                    <td colspan="3">
                                                        <input type="text" name="no_tlp" value="{{ old('phone', $profile->no_tlp) }}" placeholder="Masukkan phone " class="form-control ">
                                                        {{-- <p class="help-block">Example block-level help text here.</p> --}}
                                                        
                                                    </td>
                                                </tr>
                                                {{-- <tr>
                                                    <td>Address</td>
                                                    <td colspan="3">
                                                        <textarea id="alamat" class="form-control content " name="address" placeholder="Masukkan Konten / Isi Berita" rows="10"></textarea>
                                                        
                                                        <i style="color :orange; font-size: 10px;">Diisi dengan alamat anda tinggal</i>

                                                    </td>
                                                </tr> --}}
                                                {{-- <tr>
                                                    <td>Status</td>
                                                    <td colspan="3">
                                                        <input name="status" placeholder="Enter your First name" type="text" value="" class="form-control required">
                                                    </td>
                                                </tr> --}}
                                                <tr>
                                                    <td>Created At</td>
                                                    <td colspan="3">
                                                        1 month ago
                                                    </td>
                                                </tr>
                                                
                                            </table>
                                            
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-responsive btn-primary"><i class="fa fa-paper-plane"></i> Save</button>
                                </div>
                            </div>
                        </form>
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
            var myUptdAccess = $(this).data('uptd_access');
           
            
            console.log(id);
            const baseUrl = `{{ url('admin/master-data/user/role-akses/getData') }}/` + id;
            $.get(baseUrl, { id: id },
                function(response){

                        console.log(response);
                        $("#select_user_role").html(`<option value="${response.user_role_list[0].role_id}">${response.user_role_list[0].role}</option>`);
                        $("#uptdAccess").val( myUptdAccess );

                        for(var i=1; i<=$('#edit_select_menu').children('option').length;i++){
                            for(var j=0; j<response.user_role.length;j++){
                                if($('#menu_'+i).val() == response.user_role[j].menu){
                                    $('#menu_'+i).attr("selected","selected");
                                }
                            }
                        }
                        for(var i=1; i<=$('#edit_role_access > option').length;i++){
                            for(var j=0; j < response.role_access.length ;j++){
                                if($('#user_role_'+i).val() == response.role_access[j].role_access){
                                    $('#user_role_'+i).attr("selected","selected");
                                }
                            }
                        }
                        for(var i=1; i<=$('#edit_uptd_access').children('option').length;i++){
                            for(var j=0; j<response.uptd_access.length;j++){
                                if($('#uptd_'+i).val() == response.uptd_access[j].uptd_name){
                                    $('#uptd_'+i).attr("selected","selected");
                                }
                            }
                        }
                        $("#edit_select_menu").chosen( { width: '100%' } );
                        $("#edit_role_access").chosen( { width: '100%' } );
                        $("#edit_uptd_access").chosen( { width: '100%' } );

            });
        });

    });
</script>
@endsection
