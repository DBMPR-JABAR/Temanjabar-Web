@extends('admin.t_index')

@section('title') Ruas Jalan @endsection
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
                <h4>Detail Disposisi </h4>

            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{url('admin')}}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Disposisi</a> </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('page-body')
<div class="row">
<div class="col-xl-8 col-md-12">
                                                <div class="card">
                                                    
                                                    <div class="card-block-big">
                                                    <ul class="nav nav-tabs  tabs" role="tablist">
                                                                    <li class="nav-item">
                                                                        <a class="nav-link active" data-toggle="tab" href="#Detail" role="tab">Detail</a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" data-toggle="tab" href="#lampiran" role="tab">Lampiran</a>
                                                                    </li>

                                                                </ul>
                                                                <!-- Tab panes -->
                                                                <div class="tab-content tabs card-block">
                                                                    <div class="tab-pane active" id="Detail" role="tabpanel">
                                                                    <table class="table table-striped table-bordered nowrap dataTable">
                                                             <tr><td>	Disposisi Code</td><td>{{$detail_disposisi->disposisi_code}}</td></tr>
                                                             <tr><td>	Dari</td><td>{{$detail_disposisi->dari}}</td></tr>
                                                             <tr><td>	Perihal</td><td>{{$detail_disposisi->perihal}}</td></tr>
                                                             <tr><td>	Tanggal Surat</td><td>{{$detail_disposisi->tgl_surat}}</td></tr>

                                                             <tr><td>	No Surat</td><td>{{$detail_disposisi->no_surat}}</td></tr>
                                                             <tr><td>	Tanggal Penyelesaian</td><td>{{$detail_disposisi->tanggal_penyelesaian}}</td></tr>
                                                             <tr><td>	Status</td><td>{{$detail_disposisi->status}}</td></tr>
                                                             <tr><td>	Disposisi Kepada</td><td>
                                                             @php   $inouts = \App\Model\Transactional\DisposisiPenanggungJawab::where('disposisi_code',$detail_disposisi->disposisi_code)->get() @endphp
                                @foreach($inouts as $inout)
                                <span > {{!empty($inout->keterangan_role->keterangan) ?  $inout->keterangan_role->keterangan: "-"  }}</span><br/>
                                @endforeach

                                                             </td></tr>

                                                             <tr><td>	Created Date</td><td>{{$detail_disposisi->created_date}}</td></tr>
</table>
                                                                </div>
                                                                    <div class="tab-pane" id="lampiran" role="tabpanel">
                                                                    <?php $ex = explode(".",$detail_disposisi->file);  ?> 
                                                                    <iframe src=" {{  asset('storage/'.$detail_disposisi->file)  }}" id="pdf_display_frame" width="100%" height="600px"></iframe>
                                                                     </div>

                                                                </div>



                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-12">
                                                <div class="card feed-card">
                                                    <div class="card-header">
                                                      
                                                    </div>
                                                    <div class="row card-block">
                                                    <div class="col-md-12 col-lg-12">
                                                        <h6 class="sub-title">History</h6>
                                                    <ul class="basic-list">
                                                    @foreach($penanggung_jawab as $pj)
                                                    <?php $date = date_create($pj->created_date);?>
                                                     
                                                        <li><p> <?php echo $pj->name . '(' . $pj->keterangan . ') menerima disposisi tanggal ' . date_format($date, 'd-m-Y H:i:s') ?></p> </li>
                                                        @endforeach


                                                                </ul>
</div></div>

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- statustic-card start -->



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
            
        </div>
    </div>
</div>
 
 
@endsection
@section('script')
 
@endsection