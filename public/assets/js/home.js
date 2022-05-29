const paketUptd1 = uptd1.map(function (item) {
  var progres = sum(item.laporan_approved, "volume");
  return {
    name: item.nm_paket,
    y: progres,
    dataLabels: {
      enabled: true,
      format: "{point.y} %",
    },
  };
});

const paketUptd2 = uptd2.map(function (item) {
  var progres = sum(item.laporan_approved, "volume");
  return {
    name: item.nm_paket,
    y: progres,
  };
});

const paketUptd3 = uptd3.map(function (item) {
  var progres = sum(item.laporan_approved, "volume");
  return {
    name: item.nm_paket,
    y: progres,
  };
});

const paketUptd4 = uptd4.map(function (item) {
  var progres = sum(item.laporan_approved, "volume");
  return {
    name: item.nm_paket,
    y: progres,
  };
});

const paketUptd5 = uptd5.map(function (item) {
  var progres = sum(item.laporan_approved, "volume");
  return {
    name: item.nm_paket,
    y: progres,
  };
});

const paketUptd6 = uptd6.map(function (item) {
  var progres = sum(item.laporan_approved, "volume");
  return {
    name: item.nm_paket,
    y: progres,
  };
});

function sum(arr, prop) {
  let total = 0;
  for (let i = 0, _len = arr.length; i < _len; i++) {
    total += parseFloat(arr[i][prop], 0);
  }
  return total;
}
console.log(paketUptd6);

// Create the chart
Highcharts.chart("pembangunan_talikuat", {
  chart: {
    type: "column",
  },
  title: {
    align: "center",
    text: "Jumlah Paket Pembangunan",
  },
  subtitle: {
    align: "center",
    text: "Klik pada kolom untuk melihat detail",
  },
  accessibility: {
    announceNewData: {
      enabled: true,
    },
  },
  xAxis: {
    type: "category",
  },
  yAxis: {
    title: {
      text: "Volume",
    },
  },
  legend: {
    enabled: false,
  },
  plotOptions: {
    series: {
      borderWidth: 0,
      dataLabels: {
        enabled: true,
        format: "{point.y} Paket",
      },
    },
  },

  series: [
    {
      name: "Paket Pembangunan",
      colorByPoint: true,
      tooltip: {
        headerFormat:
          '<span style="font-size:11px">Jumlah Paket Pekerjaan {point.name}</span><br>',
        pointFormat: '<span style="color:{point.color}"><b>{point.y}</b><br/>',
      },
      data: [
        {
          name: "UPTD-1",
          y: uptd1.length,
          drilldown: "ProgresUPTD-1",
        },
        {
          name: "UPTD-2",
          y: uptd2.length,
          drilldown: "ProgresUPTD-2",
        },
        {
          name: "UPTD-3",
          y: uptd3.length,
          drilldown: "ProgresUPTD-3",
        },
        {
          name: "UPTD-4",
          y: uptd4.length,
          drilldown: "ProgresUPTD-4",
        },
        {
          name: "UPTD-5",
          y: uptd5.length,
          drilldown: "ProgresUPTD-5",
        },
        {
          name: "UPTD-6",
          y: uptd6.length,
          drilldown: "ProgresUPTD-6",
        },
      ],
    },
  ],
  drilldown: {
    breadcrumbs: {
      position: {
        align: "right",
      },
    },

    series: [
      {
        name: "Progres Paket Pembangunan",
        id: "ProgresUPTD-1",
        data: paketUptd1,
        tooltip: {
          headerFormat: '<span style="font-size:11px">Realisasi : </span><br>',
          pointFormat:
            '<span style="color:{point.color}"><b>{point.y}%</b><br/>',
        },
      },
      {
        name: "Progres Paket Pembangunan",
        id: "ProgresUPTD-2",

        data: paketUptd2,
        tooltip: {
          headerFormat: '<span style="font-size:11px">Realisasi : </span><br>',
          pointFormat:
            '<span style="color:{point.color}"><b>{point.y}%</b><br/>',
        },
      },
      {
        name: "Progres Paket Pembangunan",
        id: "ProgresUPTD-3",

        data: paketUptd3,
        tooltip: {
          headerFormat: '<span style="font-size:11px">Realisasi : </span><br>',
          pointFormat:
            '<span style="color:{point.color}"><b>{point.y}%</b><br/>',
        },
      },
      {
        name: "Progres Paket Pembangunan",
        id: "ProgresUPTD-4",

        data: paketUptd4,
        tooltip: {
          headerFormat: '<span style="font-size:11px">Realisasi : </span><br>',
          pointFormat:
            '<span style="color:{point.color}"><b>{point.y}%</b><br/>',
        },
      },
      {
        name: "Progres Paket Pembangunan",
        id: "ProgresUPTD-5",

        data: paketUptd5,
        tooltip: {
          headerFormat: '<span style="font-size:11px">Realisasi : </span><br>',
          pointFormat:
            '<span style="color:{point.color}"><b>{point.y}%</b><br/>',
        },
      },
      {
        name: "Progres Paket Pembangunan",
        id: "ProgresUPTD-6",

        data: paketUptd6,
        tooltip: {
          headerFormat: '<span style="font-size:11px">Realisasi : </span><br>',
          pointFormat:
            '<span style="color:{point.color}"><b>{point.y}%</b><br/>',
        },
      },
    ],
  },
});
