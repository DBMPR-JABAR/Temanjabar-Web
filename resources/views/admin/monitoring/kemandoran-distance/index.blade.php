@extends('admin.layout.index')

@section('title')  Kalkulasi Jarak Pekerjaan @endsection
@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/vendor/datatables.net/css/dataTables.bootstrap4.min.css') }}">

<style>
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
                <h4>Kalkulasi Jarak Pekerjaan</h4>
                <span>Data Kalkulasi Jarak Pekerjaan</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class=" breadcrumb breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{url('admin')}}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Kalkulasi Jarak Pekerjaan</a> </li>
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
                <h5 id="tbltitle">Tabel Kalkulasi Jarak Pekerjaan</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        {{-- <li><i class="feather icon-maximize full-card"></i></li> --}}
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <a href="{{ route('kemandoran-distance-export') }}" class="btn btn-mat btn-primary mb-3">Resume</a>
                <div class="dt-responsive table-responsive">
                    <table id="dttable" class="table table-striped table-bordered able-responsive">
                        <thead>
                            <tr>
                                <th>Kode Laporan</th>
                                <th>Ruas Jalan</th>
                                <th>Titik Koordinat</th>
                                <th>Jarak</th>
                                <th>Terakhir diukur</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<!-- <script src="{{ asset('assets/vendor/jquery/js/jquery-3.4.1.min.js') }}" ></script> -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

<script src="{{
    asset('assets/vendor/datatables.net/js/dataTables.bootstrap4.min.js')
}}"></script>

<script>
    $(document).ready(() => {
        $('#dttable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('kemandoran-distance-data')}}",
            columns: [
                {
                    data: 'id_pek',
                    defaultContent: ''
                },
                { data: 'ruas_jalan' },
                {
                    orderable: false,
                    defaultContent: '',
                    render: function(data, type, row)
                        {
                            return `${row.lat}, ${row.lng}`
                        }
                },
                {
                    data: 'distance',
                    orderable: true,
                    defaultContent: '',
                    render: function(data, type, row)
                        {
                            const distance = Number(data).toFixed(2);
                            if(distance < 1000)
                                return `${distance} M`;
                            else return `${(distance/1000).toFixed(2)} KM`;
                        }
                },
                {
                    data: 'calculate_time',
                    orderable: false,
                    defaultContent: '',
                    render: function(data, type, row)
                        {
                            return new Date(data).toLocaleString('id');
                        }
                },
            ]
        });
    });

</script>
@endsection
