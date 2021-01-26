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
                <h4 class="card-title">Edit Role Access</h4>
                {{-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <form action="{{route('updateRoleAccess',$alldata['role_id'])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{-- @method('PUT') --}}
                
                
                    <div class="modal-body p-5">
                
                        <div class="form-group row">
                                <label class="col-md-2 col-form-label">User Role</label>
                                <div class="col-md-10">
                                    @foreach ($user_role as $data)
                                    
                                    <select class="form-control"  name="user_role" tabindex="4" required>
                                        <option value="{{$data->id}}" checked>{{$data->role}}</option>
                                    </select>
                                    @endforeach
                                   
                                </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Menu</label>
                            {{-- <div class="col-md-10">
                                <select data-placeholder="User Role..." class="chosen-select" multiple  name="menu[]" tabindex="4" required>
                                @foreach($menu as $data)
                                    <option value="{{$data->menu}}.Create" >{{$data->menu}}.Create</option>
                                    <option value="{{$data->menu}}.View">{{$data->menu}}.View</option>
                                    <option value="{{$data->menu}}.Update">{{$data->menu}}.Update</option>
                                    <option value="{{$data->menu}}.Delete">{{$data->menu}}.Delete</option>
                                @endforeach
                                </select>
                            </div> --}}
                            <div class="col-md-10">
                                <div class="form-check-inline">    
                                    @foreach($alldata['menu'] as $data)
                                    <label class="form-check-label" for="check1">   
                                            @foreach ($alldata['permissions'] as $item)
                                            
                                            @endforeach
                                            <input type="checkbox" class="form-check-input" name="menu[]" value="{{$data}}" @if(strpos( $item, $data ) !== false) checked @endif>{{$data}}&nbsp;
                        
                                        </label>
                                        @endforeach
                                </div>
                                

                            </div>
                        </div>
                
                        {{-- <div class="form-group row">
                            <label class="col-md-2 col-form-label">Role Access</label>
                            <div class="col-md-10">
                                <select data-placeholder="User Role..." class="chosen-select" multiple  name="role_access[]" tabindex="4" required>
                                    <option value="Create" >Create</option>
                                    <option value="View">View</option>
                                    <option value="Update">Update</option>
                                    <option value="Delete">Delete</option>
                                </select>
                            </div>
                        </div> --}}
                
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">UPTD Access</label>
                            <div class="col-md-10">
                                
                                @foreach ($uptd_lists as $no => $uptd_list) 
                                    @foreach ($alldata['uptd_akses'] as $item)
                                        @php
                                        $act = " ";
                                            if ($item == $uptd_list->id) {
                                                $act = "Checked";
                                                break;
                                            }
                                        @endphp
                                    @endforeach
                                    <input type="checkbox" class="custom-checkbox" name="uptd_access[]" value="{{ $uptd_list->id }}" id="uptd_{{ $uptd_list->id }}" {{ $act }}>{{ $uptd_list->nama }}&nbsp;
                                @endforeach
                            </div>
                        </div>
                
                
                
                    </div>
                
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect " data-dismiss="modal">Kembali</button>
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
        

    });
</script>
@endsection