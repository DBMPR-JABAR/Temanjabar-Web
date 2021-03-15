@extends('admin.layout.index')

@section('title') Progress Mingguan @endsection

@section('head')
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
                <div id="test"></div>
                Testing
            </div>
        </div>
    </div>
@endsection

@section('script')
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
                let d = new Date(currentValue[key]);
                d = Math.floor(d.getTime() / (1000 * 60 * 60 * 24 * 7));
                (result[d] = result[d] || []).push(
                    dataFilter
                );
                return result;
            }, {});
            const weeklyNumbers = Object.keys(resultsUnsorting);
            let resultsSorting = [];
            weeklyNumbers.forEach((weeklyNumber) => {
                const data = sortingByDate(resultsUnsorting[weeklyNumber], key)
                resultsSorting.push({
                    minggu: weeklyNumber,
                    data
                })
            })
            return resultsSorting;
        };

        const dailyProgress = @json($progress_harian);
        const dailyProgressGroup = groupBy(dailyProgress, 'kegiatan');
        const dailyProgressName = Object.keys(dailyProgressGroup);

        let weeklyProgress = [];
        dailyProgressName.forEach((kegiatan) => {
            const firstProgress = sortingByDate(dailyProgressGroup[kegiatan], 'tgl')[0];
            const data = groupByWeek(dailyProgressGroup[kegiatan], 'tgl');
            weeklyProgress.push({
                tanggal_awal: firstProgress.tgl,
                tanggal_akhir: addDays(firstProgress.tgl, firstProgress.waktu_pelaksanaan),
                nama_kegiatan: kegiatan,
                waktu_pelaksanaan: firstProgress.waktu_pelaksanaan,
                data_mingguan: data
            });
        })

        console.log(weeklyProgress);

        $(document).ready(() => {
            $('#test').text(JSON.stringify(weeklyProgress))
        })

    </script>
@endsection
