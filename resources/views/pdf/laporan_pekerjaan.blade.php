<html>

<head>
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/files/bower_components/bootstrap/css/bootstrap.min.css') }}">
    <script type="text/javascript" src="{{ asset('assets/files/bower_components/jquery/js/jquery.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('assets/files/bower_components/jquery-ui/js/jquery-ui.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('assets/files/bower_components/popper.js/js/popper.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('assets/files/bower_components/bootstrap/js/bootstrap.min.js') }}">
    </script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
    @php
        $no = 0;
    @endphp
    @foreach ($temporari as $data)
        <page size="A4">
            <div class="row g-3">
                <div class="col-3 p-2">
                    <img id="logo" class="float-right" src="{{ asset('logo.png') }}" alt="logo" />
                </div>
                <div class="col-8 judul p-2 text-center">
                    <p>PEMERINTAH PROVINSI JAWA BARAT</p>
                    <p>DINAS BINA MARGA DAN PENATAAN RUANG</p>
                    <p>UNIT PELAKSANA TEKNIS DAERAH WILAYAH PELAYANAN UPTD {{ @$data->uptd_romawi }}</p>
                    <p>SUB KEGIATAN PEMELIHARAAN RUTIN JALAN</p>
                    <h5 class="mt-2 font-weight-bold">BUKU HARIAN STANDAR</h5>
                </div>
                <div class="col-1">
                    <button id="cetak" type="button" class=" text-right">CETAK</button>
                </div>
            </div>
            <br>
            <div class="row ml-4">
                <table id="table_judul" class="col-12">
                    <tbody>
                        <tr>
                            <td style="width: 20%">SUB KEGIATAN
                            </td>
                            <td style="width: 2%">:
                            </td>
                            <td><input name="tanggal" type="text" value="{{ @$data->sub_kegiatan }}" class="dotted"
                                    readonly>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>SPPJ WILAYAH
                            </td>
                            <td>:
                            </td>
                            <td><input name="tanggal" type="text" value="{{ @$data->sppj_wilayah }}" class="dotted"
                                    readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>TANGGAL/HARI
                            </td>
                            <td>:
                            </td>
                            <td><input name="tanggal" type="text" value="{{ @$data->tanggal_hari }}" class="dotted"
                                    readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>RUAS JALAN/LOKASI
                            </td>
                            <td>:
                            </td>
                            <td><input name="tanggal" type="text" value="{{ @$data->ruas_jalan }}" class="dotted"
                                    readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>KM/HM
                            </td>
                            <td>:
                            </td>
                            <td> <input name="tanggal" type="text"
                                    value="{{ @$data->km }}" class="dotted" readonly>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
                <table id="table_judul" class="col-12 d-flex justify-content-end pr-3">
                    <tbody>
                        <tr>
                            <td ></td>
                            
                            <td style="width: 20%">HALAMAN
                            </td>
                            <td style="width: 2%">:
                            </td>
                            <td style="width: 22%"><input name="tanggal" type="text"
                                    value="{{ ++$no }} Dan {{ @$data->hal_ke }}"
                                    class="dotted col-12 no_right_pad" readonly>
                            </td>
                            
                        </tr>
                    </tbody>
                </table>
            </div>
            <br>
            <div class="row">
                {{-- <div class="col-7">
                    <div class="row">
                        <div class="col-12">
                            <p class=" font-weight-bold">A. TENAGA KERJA</p>
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>JABATAN</th>
                                        <th>SATUAN</th>
                                        <th>JUMLAH</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($data->tenaga_kerja as $row)
                                        <tr>
                                            <td>{{ $no }}
                                            </td>
                                            <td>{{ $row['jabatan'] }}
                                            </td>
                                            <td>{{ $row['satuan'] }}
                                            </td>
                                            <td>{{ $row['jumlah'] }}
                                            </td>
                                        </tr>
                                        @php
                                            $no++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12">
                            <p class=" font-weight-bold">C. HASIL YANG DICAPAI</p>
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>JENIS PEKERJAAN</th>
                                        <th>SATUAN VOLUME</th>
                                        <th>PERKIRAAN KUANTITAS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4">I. PEMELIHARAAN JALAN
                                        </td>
                                    </tr>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($data->hasil_dicapai->pemeliharaan_jalan as $row)
                                        <tr>
                                            <td>{{ $no }}
                                            </td>
                                            <td>{{ $row['jenis_pekerjaan'] }}
                                            </td>
                                            <td>{{ $row['satuan'] }}
                                            </td>
                                            <td>{{ $row['perkiraan_kuantitas'] }}
                                            </td>
                                        </tr>
                                        @php
                                            $no++;
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="4">II. PEMELIHARAAN JEMBATAN
                                        </td>
                                    </tr>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($data->hasil_dicapai->pemeliharaan_jembatan as $row)
                                        <tr>
                                            <td>{{ $no }}
                                            </td>
                                            <td>{{ $row['jenis_pekerjaan'] }}
                                            </td>
                                            <td>{{ $row['satuan'] }}
                                            </td>
                                            <td>{{ $row['perkiraan_kuantitas'] }}
                                            </td>
                                        </tr>
                                        @php
                                            $no++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12">
                            <p class=" font-weight-bold">E. PENGHAMBAT PELAKSANAAN</p>
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>JENIS GANGGUAN DAN CUACA</th>
                                        <th>WAKTU</th>
                                        <th>AKIBAT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($data->penghambat_pelaksanaan as $row)
                                        <tr>
                                            <td>{{ $no }}
                                            </td>
                                            <td>{{ $row['jenis_gangguan_dan_cuaca'] }}
                                            </td>
                                            <td>{{ $row['waktu'] }}
                                            </td>
                                            <td>{{ $row['akibat'] }}
                                            </td>
                                        </tr>
                                        @php
                                            $no++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="row">
                        <div class="col-12">
                            <p class=" font-weight-bold">B. MATERIAL TIBA DI LOKASI</p>
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>JABATAN</th>
                                        <th>SATUAN</th>
                                        <th>JUMLAH</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($data->material_tiba as $row)
                                        <tr>
                                            <td>{{ $no }}
                                            </td>
                                            <td>{{ $row['jenis_material'] }}
                                            </td>
                                            <td>{{ $row['satuan'] }}
                                            </td>
                                            <td>{{ $row['kuantitas'] }}
                                            </td>
                                        </tr>
                                        @php
                                            $no++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12">
                            <p class=" font-weight-bold">D. BAHAN OPERASIONAL PERALATAN</p>
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>JENIS BAHAN BAKAR</th>
                                        <th>SATUAN</th>
                                        <th>KUANTITAS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($data->bahan_operasional as $row)
                                        <tr>
                                            <td>{{ $no }}
                                            </td>
                                            <td>{{ $row['jenis_bahan_bakar'] }}
                                            </td>
                                            <td>{{ $row['satuan'] }}
                                            </td>
                                            <td>{{ $row['kuantitas'] }}
                                            </td>
                                        </tr>
                                        @php
                                            $no++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12">
                            <p class=" font-weight-bold">F. PERALATAN YANG DIGUNAKAN</p>
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>JENIS PERALATAN</th>
                                        <th>SATUAN</th>
                                        <th>KUANTITAS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($data->peralatan as $row)
                                        <tr>
                                            <td>{{ $no }}
                                            </td>
                                            <td>{{ $row['jenis_peralatan'] }}
                                            </td>
                                            <td>{{ $row['satuan'] }}
                                            </td>
                                            <td>{{ $row['kuantitas'] }}
                                            </td>
                                        </tr>
                                        @php
                                            $no++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="row">
                {{-- <div class="col-12">
                    <p class=" font-weight-bold">A. TENAGA KERJA</p>
                    <table class="table table-sm table-bordered text-center">
                        <tbody>
                            <tr>
                                <th style="width: 20%">
                                </th>
                                <th style="width: 60%">USUL/SARAN/INTRUKSI
                                </th>
                                <th style="width: 20%">TANDA TANGAN
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        <table class="ttd table table-borderless no_border" style="width: 100%;">
                                            <tr class="no_border">
                                                <td class="no_border">
                                                    <p style="font-size: 7px" class="pb-0 mb-0">Dibuat oleh :</p>
                                                </td>
                                            </tr>
                                            <tr class="no_border">
                                                <td class="no_border">
                                                    <p class="text-center pb-0 mb-0">{{ @$data->pengamat }}</p>
                                                </td>
                                            </tr>
                                            <tr class="no_border">
                                                <td class="no_border">
                                                    <p class="text-center font-weight-bold pb-0 mb-0">PENGAMAT</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                                <td class=" align-middle">
                                    <p class="text-center ">{{ @$data->usulan_pengamat }}</p>
                                </td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        <table class="ttd table table-borderless no_border" style="width: 100%;">
                                            <tr>
                                                <td class="no_border">
                                                    <p style="font-size: 7px" class="pb-0 mb-0">Diperikas oleh :</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="no_border">
                                                    <p class="text-center pb-0 mb-0">{{ @$data->ksppjj }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="no_border">
                                                    <p class="text-center font-weight-bold pb-0 mb-0">KSPPJJ</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                                <td class=" align-middle">
                                    <p class="text-center ">{{ @$data->usulan_ksppjj }}</p>
                                </td>
                                <td>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> --}}
            </div>
        </page>
        
    @endforeach
    <style>
        .no_border {
            border: none !important
        }

        #table_judul {
            border: none;
            font-size: 10px
        }

        table {
            font-size: 10px
        }

        @page {
            size: 21cm 29.7cm;
            margin: 0;
            padding: 0
        }

        .form-group .row {
            margin-bottom: 0;
            padding-bottom: 0
        }

        .no_right_pad {
            padding-right: 0;
            padding-left: 0
        }

        .hal_ {
            margin: 0;
            padding: 3px 0 5px 0
        }

        .form-group {
            margin-top: 0
        }

        .colon {
            text-align: right;
            margin: 0;
            padding: 0
        }

        label {
            height: 0;
        }

        input {
            height: 12px;
            width: 100%
        }

        .dotted {
            border: 0;
            border-bottom: 1px dotted;
        }

        body {
            background: rgb(204, 204, 204);
            margin: 0;
            padding: 0;
            font-size: 10px !important
        }

        html {
            margin: 0;
            padding: 0;
            min-width: 21cm;
            min-height: 29.7cm;
            font-size: 8px;
        }

        page {
            background: white;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
            padding: 1cm 1.5cm
        }

        page[size="A4"] {
            width: 21cm;
            height: 29.7cm;
        }

        @media print {

            #cetak {
                display: none
            }

            body,
            page {
                margin: 0;
                box-shadow: 0;
            }


            .no_border {
                border: none !important
            }

            .ttd {
                border: solid;
                white !important;
                border-width: 0 !important;
                border-bottom-style: none;
            }

            .ttd th,
            .ttd td {
                border: solid;
                white !important;
                border-width: 0 !important;
                border-bottom-style: none;
            }
        }

        #logo {
            height: 3cm;
        }

        .judul {
            text-align: right;
        }

        .judul p {
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 1.5px
        }

    </style>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('cetak').addEventListener('click', () => {
                window.print();
            })
        })

    </script>
</body>

</html>
