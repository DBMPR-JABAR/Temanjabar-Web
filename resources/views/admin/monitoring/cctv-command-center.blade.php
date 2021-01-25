@extends('admin.t_index')

@section('title') CCTV Command Center @endsection

@section('head')
    <link href="https://vjs.zencdn.net/7.2.3/video-js.css" rel="stylesheet">
    <link href="https://unpkg.com/@videojs/themes@1/dist/city/index.css" rel="stylesheet" />
@endsection
@section('page-header')
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>CCTV Command Center</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ url('admin') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">CCTV Command Center</a> </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('page-body')
    <div class="row d-flex justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-block accordion-block">
                    <div id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="accordion-panel">
                            <div class="accordion-heading" role="tab" id="headingOne">
                                <h3 class="card-title accordion-title">
                                    <a class="accordion-msg" data-toggle="collapse" data-parent="#accordion"
                                        href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Filter
                                    </a>
                                </h3>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in show" role="tabpanel"
                                aria-labelledby="headingOne">
                                <div class="accordion-content accordion-desc">
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-sm-12 col-xl-3 m-b-30">
                                                <h4 class="sub-title">UPTD</h4>
                                                <select id="filterUPTD" name="select"
                                                    class="form-control form-control-primary" onchange="changeUPTD(this)">
                                                    @if (Auth::user()->internalRole->uptd)
                                                        <option value="{{ Auth::user()->internalRole->uptd }}" selected>
                                                            UPTD
                                                            {{ str_replace('uptd', '', Auth::user()->internalRole->uptd) }}
                                                        </option>
                                                    @else
                                                        <option value="semua" selected>Semua</option>
                                                        @foreach ($uptd_lists as $uptd)
                                                            <option value="{{ $uptd->id }}">{{ $uptd->nama }}</option>
                                                        @endforeach
                                                    @endif
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
        <div class="col-lg-12">
            <div class="card pt-3 pb-3">
                <div class="row gx-2">
                    @foreach ($cctv as $item)
                        <div
                            class="col-xl-4 col-md-6 d-flex justify-content-center mx-auto {{ 'ID-' . $item->UPTD_ID }} cctvItem">
                            <div class="card videoContainer">
                                <video id='{{ 'CCTV-' . $item->ID }}' class="video-js vjs-theme-city9 videoIdentity"
                                    controls autoplay>
                                    <source type="application/x-mpegURL" src="{{ $item->URL }}">
                                </video>
                                <div class="card-footer bg-c-blue">
                                    <div class="row align-items-center">
                                        <div class="col-9">
                                            <p class="text-white m-b-0">{{ $item->LOKASI }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <style>
        .videoContainer {
            width: 400px;
            height: 300px;
        }

        .videoIdentity {
            width: 100%;
            height: 100%;
        }

        .ID-3 {
            display: none
        }

    </style>
@endsection

@section('script')
    <script src="https://vjs.zencdn.net/ie8/ie8-version/videojs-ie8.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-hls/5.14.1/videojs-contrib-hls.js"></script>
    <script src="https://vjs.zencdn.net/7.2.3/video.js"></script>

    <script>
        const cctvs = @json($cctv)
        //  const uptds = @json($uptd_lists)
        // console.log(uptds)
        $(document).ready(()=>{
            cctvs.forEach((cctv) => {
                videojs(`CCTV-${cctv.ID}`).play()
            })
            videojs.options.autoplay = true;
        })
        const uptdList = {!!json_encode($uptd_lists->toArray())!!};
        //console.log(uptdList)

        function changeUPTD(val) {
            console.log(val.value)

           const uptd1 = cctvs.filter((item)=>{
               return item.id
           })

            if (val.value == 'semua') {
                uptdList.forEach((uptd) => {
                    $(`.ID-${uptd.id}`).hide();
                    console.log(uptd.id)
                })
            } else {
                uptdList.forEach((uptd) => {
                    $(`.ID-${uptd.id}`).hide();
                })
                $(`.ID-${val.value}`).show();
            }
        }

    </script>
@endsection
