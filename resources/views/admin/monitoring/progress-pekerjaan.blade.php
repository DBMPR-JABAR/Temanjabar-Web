@extends('admin.t_index')

@section('title') Admin Dashboard @endsection

@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Peta Jabar Distribusi Progress Pekerjaan</h4>
             </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="index.html"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Progress Pekerjaan</a> </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('page-body')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <section id="our-services" class="pt-5 bglight">
                <div class="container">
                    <div class="row whitebox top15">
                        
                        <div class="col-lg-12 col-md-12">
                            <div class="widget heading_space text-center text-md-left">

                                <div class="col-12 px-0">
                                    <div class="w-100">
                                        <iframe style="border:0px" src="http://talikuat-bima-jabar.com/temanjabar/mob/dinas/progress.php" title="Progress Pekerjaan" width="100%" height="400"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
           
        </div><div class="card">
            <div class="card-block">
                <div class="table-responsive dt-responsive">
                    <table id="kontraktor" class="table table-striped table-bordered ">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Paket</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Jenis Pekerjaan</th>
                                <th>Ruas Jalan</th>
                                <th>Lokasi</th>
                                <th>Rencana</th>
                                <th>Realisasi</th>
                                <th>Deviasi</th>
                            </tr>
                        </thead>
                     <tbody>
    
                        
                            <tr>
                                <td>1</td>
                                <td>Paket Pekerjaan Peningkatan Jalan Ruas Jalan Cibadak - Cikidang - Pelabuhan Ratu </th>
                                <td style="color: green"><b>On Progress</b></td>
                                <td>2019-10-20</td>
                                <td>Hotmix</td>
                                <td> Cibadak - Cikidang - Pelabuhan Ratu</td>
                                <td>113+950 - 115+950</td>
                                <td>37.3470%</td>
                                <td>60.3160%</td>
                                <td>22.9690%</td>
                            </tr>
                        
                            <tr>
                                <td>2</td>
                                <td>Paket Pekerjaan Peningkatan Jalan Bts. Karawang/Purwakarta (Curug) - Purwakarta </th>
                                <td style="color: blue"><b>Finish</b></td>
                                <td>2020-01-01</td>
                                <td>Hotmix</td>
                                <td> Bts. Karawang/Purwakarta (Curug) - Purwakarta</td>
                                <td>Km. Jkt. 100+500 - Km. Jkt. 101+300</td>
                                <td>100.0000%</td>
                                <td>100.0000%</td>
                                <td>0.0000%</td>
                            </tr>

                            <tr>
                                <td>3</td>
                                <td>Paket Pekerjaan Perbaikan Badan Jalan Ruas Jalan Sp. Waluran - Malereng - Tamanjaya - Ciwaru Km.Bdg. </th>
                                <td style="color: red"><b>Off Progress</b></td>
                                <td>2019-09-25</td>
                                <td>box culvert</td>
                                <td> Waluran-Malereng-Palangpang</td>
                                <td>211+500</td>
                                <td> 2.0400%</td>
                                <td>0.0000%</td>
                                <td> -2.0400%</td>
                            </tr>

                       
                     </tbody>
                     </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBSpJ4v4aOY7DEg4QAIwcSFCXljmPJFUg&callback=initMap">
</script>
@endsection