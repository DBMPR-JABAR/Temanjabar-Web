@extends('admin.layout.index')

@section('title') Progress Mingguan @endsection

@section('head')
    <!-- Highchart -->
    <style>
        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 80%;
            max-width: 800px;
            margin: 1em auto;
        }

        #container {
            height: 400px;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #EBEBEB;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }

    </style>
    <!-- JSON Viewer -->
    <link href="https://cdn.jsdelivr.net/npm/jquery.json-viewer@1.4.0/json-viewer/jquery.json-viewer.css" type="text/css"
        rel="stylesheet">
@endsection

@section('page-header')
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Progress Mingguan</h4>
                    {{-- <span></span> --}}
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class=" breadcrumb breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ url('admin') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Progress Mingguan</a> </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('page-body')
    <div class="row d-flex justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <figure class="highcharts-figure">
                    <div id="container"></div>
                    <p class="highcharts-description">
                        Testing Template Kurva S
                    </p>
                </figure>
                <p class="p-2">Data : </p>
                <div class="row">
                    <div class="col-6">
                        <pre id="weeklyProgress"></pre>
                    </div>
                    <div class="col-6">
                        <pre id="schedulePlan"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Highchart -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <!-- Json Viewer -->
    <script src="https://cdn.jsdelivr.net/npm/jquery.json-viewer@1.4.0/json-viewer/jquery.json-viewer.js"></script>
    <script>
        const addDays = (date, days) => {
            const result = new Date(date);
            result.setDate(result.getDate() + days);
            return result.toISOString().slice(0, 10);
        }

        const sortingByDate = (array, key) => {
            return array.sort((a, b) => {
                return Date(a[key]) > Date(b[key]) ? 1 : -1;
            })
        }

        const groupBy = (array, key) => {
            return array.reduce((result, currentValue) => {
                (result[currentValue[key]] = result[currentValue[key]] || []).push(
                    currentValue
                );
                return result;
            }, {});
        };

        const groupByWeek = (array, key) => {
            const resultsUnsorting = array.reduce((result, currentValue) => {
                const {
                    ['waktu_pelaksanaan']: remove, ...dataFilter
                } = currentValue;
                // dataFilter = currentValue;
                let d = new Date(currentValue[key]);
                d = Math.floor(d.getTime() / (1000 * 60 * 60 * 24 * 7));
                (result[d] = result[d] || []).push(
                    dataFilter
                );
                return result;
            }, {});
            const weeklyNumbers = Object.keys(resultsUnsorting);
            let resultsSorting = [];
            let weeklyNumbersTemp = 0;
            weeklyNumbers.forEach((weeklyNumber, index) => {
                const data = sortingByDate(resultsUnsorting[weeklyNumber], key)
                let volume = 0;
                let nilai = 0;
                data.forEach((item) => {
                    volume += Number(item.volume);
                    nilai += Number(item.nilai);
                })
                resultsSorting.push({
                    minggu_number: weeklyNumber,
                    minggu_ke: (index === 0) ? 1 : (resultsSorting[index - 1].minggu_ke + (Number(
                        weeklyNumber) - weeklyNumbersTemp)),
                    volume_migguan: volume,
                    nilai_mingguan: nilai,
                    data
                })
                weeklyNumbersTemp = Number(weeklyNumber);
            })
            return resultsSorting;
        };

        const dailyProgress = @json($progress_harian);
        const dailyProgressGroup = groupBy(dailyProgress, 'kegiatan');
        const dailyProgressName = Object.keys(dailyProgressGroup);
        const schedule = @json($jadwal);
        const scheduleGroup = groupBy(schedule, 'kegiatan');

        let schedulePlan = [];
        dailyProgressName.forEach((progress) => {
            let volume = 0;
            // console.log(scheduleGroup[progress])
            scheduleGroup[progress].forEach((progressPlan) => {
                volume += Number(progressPlan.volume)
            })
            schedulePlan.push({
                nama_kegiatan: progress,
                total_volume: volume
            })
        })
        console.log('schedulePlan', schedulePlan);

        let weeklyProgress = [];
        dailyProgressName.forEach((progress) => {
            const firstProgress = sortingByDate(dailyProgressGroup[progress], 'tgl')[0];
            const data = groupByWeek(dailyProgressGroup[progress], 'tgl');
            let volume = 0;
            let nilai = 0;
            data.forEach((item) => {
                volume += item.volume_migguan;
                nilai += item.nilai_mingguan;
            })
            // console.log(data)
            weeklyProgress.push({
                tanggal_awal: firstProgress.tgl,
                tanggal_akhir: addDays(firstProgress.tgl, firstProgress.waktu_pelaksanaan),
                nama_kegiatan: progress,
                waktu_pelaksanaan: firstProgress.waktu_pelaksanaan,
                total_volume: volume,
                total_nilai: nilai,
                data_mingguan: data
            });
        })
        // console.log(weeklyProgress);
        $(document).ready(() => {
            $('#weeklyProgress').jsonViewer({weeklyProgress});
            $('#schedulePlan').jsonViewer({schedulePlan});
        })

        const activityName = "1 Km Pelebaran Jalan Menuju BIJB Tahap 2";
        let dataWeeklyProgress = [];
        let dataWeeklyCategories = [];
        let dataWeeklyTotalProgressTemp = [];
        let dataWeeklyTotalProgress = [];
        const weeklyProgressFilter = weeklyProgress.filter((progress)=> {
            return progress.nama_kegiatan == activityName;
        })
        const schedulePlanFilter = schedulePlan.filter((schedule)=> {
            return schedule.nama_kegiatan == activityName;
        })

        weeklyProgressFilter[0].data_mingguan.forEach((progress, index)=> {
            console.log(progress);
            dataWeeklyProgress.push(progress.volume_migguan);
            dataWeeklyCategories.push(`Minggu ke-${progress.minggu_ke}`);
            let weeklyProgressPercent = (progress.volume_migguan / schedulePlanFilter[0].total_volume) * 100;

            index == 0 ?
            dataWeeklyTotalProgress.push(weeklyProgressPercent) :
            dataWeeklyTotalProgress.push( dataWeeklyTotalProgress[index-1] + weeklyProgressPercent);
        })

        // console.log('dataWeeklyProgress', dataWeeklyProgress);
        // console.log('dataWeeklyCategories',dataWeeklyCategories);
        // console.log('schedulePlanFilter',schedulePlanFilter);
        // console.log('dataWeeklyTotalProgressTemp',dataWeeklyTotalProgressTemp);
        // console.log('dataWeeklyTotalProgress',dataWeeklyTotalProgress);

        Highcharts.chart('container', {
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: weeklyProgressFilter[0].nama_kegiatan
            },
            // subtitle: {
            //     text: 'Testing Nama Paket'
            // },
            xAxis: [{
                categories: dataWeeklyCategories,
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}°C',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: 'Temperature',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text: 'Rainfall',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                labels: {
                    format: '{value} mm',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            legend: {
                layout: 'vertical',
                align: 'left',
                x: 120,
                verticalAlign: 'top',
                y: 100,
                floating: true,
                backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || // theme
                    'rgba(255,255,255,0.25)'
            },
            series: [{
                name: 'Progress Mingguan',
                type: 'column',
                yAxis: 1,
                data: dataWeeklyProgress,
                tooltip: {
                    valueSuffix: ' mm'
                }

            }, {
                name: 'Progress',
                type: 'spline',
                data: dataWeeklyTotalProgress,
                tooltip: {
                    valueSuffix: '°C'
                }
            }]
        });

    </script>
@endsection
