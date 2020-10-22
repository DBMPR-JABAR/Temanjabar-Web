@extends('admin.t_index')

@section('title') Admin Dashboard @endsection

@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Executive Dashboard</h4>
             </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{url('admin')}}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Survey Kondisi Jalan</a> </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('page-body')
<style>

#controls {
  overflow: hidden;
  padding-bottom: 3px;
}
</style>

<div class="row">
<div class="col-lg-12">
   <div class="card">
     <div class="card-block accordion-block">
        <div id="accordion" role="tablist" aria-multiselectable="true">
            <div class="accordion-panel">
                  <div class="accordion-heading" role="tab" id="headingOne">
                     <h3 class="card-title accordion-title">
                     <a class="accordion-msg" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Filter
                     </a>
                     </h3>
                    </div>
                                                                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                                                    <div class="accordion-content accordion-desc">

                                                                    <div class="card-block">
                                                    <div class="row">
                                                    <div class="col-sm-12 col-xl-3 m-b-30">
                                                            <h4 class="sub-title">UPTD</h4>
                                                            <select name="select" class="form-control form-control-primary">
                                                                <option value="opt1">Semua</option>
                                                                <option value="opt2">UPTD 1 Sukabumi</option>
                                                                <option value="pembangunan">UPTD 2 ....</option>
                                                                <option value="peningkatan">UPTD 3 </option>
                                                                <option value="peningkatan">UPTD 4 </option>
                                                                <option value="peningkatan">UPTD 5 </option>
                                                                <option value="peningkatan">UPTD 6  </option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-12 col-xl-3 m-b-30">
                                                            <h4 class="sub-title">SPP</h4>
                                                            <select name="select" class="form-control form-control-primary">
                                                                <option value="opt1">-</option>
                                                                <option value="opt2">SPP KAB/KOTA SMI-1</option>
                                                                <option value="opt3">SPP KAB SMI-2</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-12 col-xl-3 m-b-30">
                                                            <h4 class="sub-title">Kegiatan</h4>
                                                            <select name="select" class="form-control form-control-primary">
                                                                <option value="opt1">Semua</option>
                                                                <option value="opt2">Ruas Jalam</option>
                                                                <option value="opt2">Jembatan</option>
                                                                <option value="pembangunan">Pemeliharaan</option>
                                                                <option value="pembangunan">Peningkatan</option>
                                                                <option value="pembangunan">Pembangunan</option>

                                                                <option value="peningkatan">Peningkatan</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-sm-12 col-xl-3 m-b-30">
                                                            <h4 class="sub-title">Proyek Kontrak</h4>
                                                            <select name="select" class="form-control form-control-primary">
                                                            <option value="opt1">Semua</option>
                                                                <option value="opt1">On-Progress</option>
                                                                <option value="opt2">Critical Contract</option>
                                                                <option value="opt2">Off Progress</option>
                                                                <option value="pembangunan">Finish</option>
                                                             
                                                            </select>
                                                        </div>

                                                      </div>
                                                  </div>
                                                                  </div>
                                                                </div>
                                                            </div>
                                                         </div>
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div class="col-xl-12 col-md-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>Maps</h5>
                                                        <span class="text-muted">  </span>
                                                        <div class="card-header-right">
                                                            <ul class="list-unstyled card-option">
                                                                <li><i class="feather icon-maximize full-card"></i></li>
                                                                <li><i class="feather icon-minus minimize-card"></i></li>
                                                                <li><i class="feather icon-trash-2 close-card"></i></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="card-block">
                                                    <div id="googleMap" style="width:100%;height:600px;"></div>
                                                     </div>
                                                </div>
                                            </div>

    
</div>
@endsection
@section('script')
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBSpJ4v4aOY7DEg4QAIwcSFCXljmPJFUg&callback=initMap">
</script>
<script>
    var points = [
        ['UPTD 1', -6.806124, 107.145195, 12, `{{ route('kondisiJalanUPTD','uptd1') }}`],
        ['UPTD 2', -6.930913, 106.937304, 11, `{{ route('kondisiJalanUPTD','uptd2') }}`],
        ['UPTD 3', -6.9147444,107.6098111, 10, `{{ route('kondisiJalanUPTD','uptd3') }}`],
        ['UPTD 4', -6.953272, 107.942720, 9, `{{ route('kondisiJalanUPTD','uptd4') }}`],
        ['UPTD 5', -7.461755, 108.386391, 8, `{{ route('kondisiJalanUPTD','uptd5') }}`],
        ['UPTD 6', -6.741323, 108.364521, 7, `{{ route('kondisiJalanUPTD','uptd6') }}`]
    ];

    function setMarkers(map, locations) {
        var shape = {
            coord: [1, 1, 1, 20, 18, 20, 18 , 1],
            type: 'poly'
        };

        for (var i = 0; i < locations.length; i++) {
            // var flag = new google.maps.MarkerImage('markers/' + (i + 1) + '.png',
            // new google.maps.Size(17, 19),
            // new google.maps.Point(0,0),
            // new google.maps.Point(0, 19));

            var place = locations[i];
            var myLatLng = new google.maps.LatLng(place[1], place[2]);
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: place[0],
                zIndex: place[3],
                url: place[4]
            });
            google.maps.event.addListener(marker, 'click', function() {
                window.location.href = this.url;
            });
        }
    }

    function initMap() {
        var options = {
            center:new google.maps.LatLng(-6.9032739,107.5731165),
            zoom:9,
            mapTypeId:google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("googleMap"),options);
        setMarkers(map, points);
    }
        // event jendela di-load
        //google.maps.event.addDomListener(window, 'load', initialize);
</script>
@endsection
