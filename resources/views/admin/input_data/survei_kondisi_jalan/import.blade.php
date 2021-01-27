@extends('admin.t_index')

@section('title') Survei Kondisi Jalan @endsection
@section('page-header')
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Survei Kondisi Jalan</h4>
                    <span>Seluruh Survei Kondisi Jalan yang ada di naungan DBMPR Jabar</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ url('admin') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('survei_kondisi_jalan') }}">Survei Kondisi Jalan</a> </li>
                    <li class="breadcrumb-item"><a href="#">Import</a> </li>
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
                    <h5>Import Data Survei Kondisi Jalan</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-maximize full-card"></i></li>
                            <li><i class="feather icon-minus minimize-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block pl-5 pr-5 pb-5">


                    <button type="button" class="btn btn-primary mr-5" data-toggle="modal" data-target="#importExcel">
                        IMPORT EXCEL
                    </button>

                    <!-- Import Excel -->
                    <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form method="post" action="{{ route('survei_kondisi_jalan.import') }}"
                                enctype="multipart/form-data">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                                    </div>
                                    <div class="modal-body">

                                        {{ csrf_field() }}

                                        <label>Pilih file excel</label>
                                        <div class="form-group">
                                            <input type="file" name="file" required="required">
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Import</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>



                    <a href="/siswa/export_excel" class="btn btn-success my-3" target="_blank">EXPORT EXCEL</a>

                    <div class="dt-responsive table-responsive">
                        <table id="surveikondisijalan-table" class="table table-striped table-bordered able-responsive">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Ruas Jalan</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Distance</th>
                                    <th>Speed</th>
                                    <th>Altitude</th>
                                    <th>Altitude-10</th>
                                    <th>eIri</th>
                                    <th>cIri</th>
                                    <th>Dibuat</th>
                                    <th>Diupdate</th>
                                    <th style="min-width: 75px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="bodyJembatan">
                                @foreach ($surveiKondisiJalan as $data)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->id_ruas_jalan }}</td>
                                        <td>{{ $data->latitude }}</td>
                                        <td>{{ $data->longitude }}</td>
                                        <td>{{ $data->distance }}</td>
                                        <td>{{ $data->speed }}</td>
                                        <td>{{ $data->altitude }}</td>
                                        <td>{{ $data->altitude_10 }}</td>
                                        <td>{{ $data->e_iri }}</td>
                                        <td>{{ $data->c_iri }}</td>
                                        @if (Count($users->where('id', $data->created_user)) > 0)
                                            <td>{{ $users->where('id', $data->created_user)->first()->name }}</td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        @if (Count($users->where('id', $data->updated_user)) > 0)
                                            <td>{{ $users->where('id', $data->updated_user)->first()->name }}</td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        <td style="min-width: 75px;">
                                            <div class="btn-group " role="group" data-placement="top" title=""
                                                data-original-title=".btn-xlg">
                                                @if (hasAccess(Auth::user()->internal_role_id, 'Kondisi Jalan', 'Update'))
                                                    <a href="{{ route('survei_kondisi_jalan.edit', $data->id) }}"><button
                                                            class="btn btn-primary btn-sm waves-effect waves-light"
                                                            data-toggle="tooltip" title="Edit"><i
                                                                class="icofont icofont-pencil"></i></button></a>
                                                @endif
                                                @if (hasAccess(Auth::user()->internal_role_id, 'Kondisi Jalan', 'Delete'))
                                                    <a href="#delModal" data-id="{{ $data->id }}"
                                                        data-toggle="modal"><button
                                                            class="btn btn-danger btn-sm waves-effect waves-light"
                                                            data-toggle="tooltip" title="Hapus"><i
                                                                class="icofont icofont-trash"></i></button></a>
                                                @endif
                                            </div>
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

@endsection

@section('script')
    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net/js/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery/js/jquery.mask.js') }}"></script>

    <script>
    </script>
@endsection
