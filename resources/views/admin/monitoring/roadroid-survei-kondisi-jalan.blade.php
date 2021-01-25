<figure class="highcharts-figure">
    <div id="containerEiri"></div>
    <p class="highcharts-description">
        {{ $id }}
    </p>
</figure>
<figure class="highcharts-figure">
    <div id="containerSpeedAltitude"></div>
    <p class="highcharts-description">
        {{ $id }}
    </p>
</figure>

<style>
    .highcharts-figure,
    .highcharts-data-table table {
        min-width: 360px;
        max-width: 800px;
        margin: 1em auto;
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

<!-- Resources -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/boost.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<!-- Chart code -->
<script>
    function getData(n) {
        var arr = [],
            i,
            x,
            a,
            b,
            c,
            spike;
        let dummy = 0;
        for (
            i = 0, x = 550 - n * 36e5; i < n; i = i + 1, x = x + 36e5
        ) {
            if (i % 100 === 0) {
                a = 2 * Math.random();
            }
            if (i % 1000 === 0) {
                b = 2 * Math.random();
            }
            if (i % 10000 === 0) {
                c = 2 * Math.random();
            }
            if (i % 50000 === 0) {
                spike = 10;
            } else {
                spike = 0;
            }
            arr.push([
                dummy++,
                2 * Math.sin(i / 100) + a + b + c + spike + Math.random()
            ]);
        }
        return arr;
    }
    var n = 500,
        dataAltitude = getData(n),
        dataSpeed = getData(n),
        dataEiri = getData(n),
        dataCiri = getData(n);;

    console.log(dataAltitude)
    console.log(dataSpeed)
    Highcharts.chart('containerEiri', {

        chart: {
            zoomType: 'x'
        },

        colors: ['red', 'green',
        ],

        title: {
            text: 'eIRI & cIRI'
        },

        // subtitle: {
        //     text: 'Using the Boost module'
        // },

        tooltip: {
            valueDecimals: 2
        },

        xAxis: {
            type: 'linear'
        },

        series: [{
                data: dataEiri,
                lineWidth: 0.5,
                name: 'eIRI'
            },
            {
                data: dataCiri,
                lineWidth: 0.5,
                name: 'cIRI'
            }
        ]

    });

    Highcharts.chart('containerSpeedAltitude', {

        chart: {
            zoomType: 'x'
        },
        colors: ['green','red',
        ],
        title: {
            text: 'Speed Altitude'
        },

        // subtitle: {
        //     text: 'Using the Boost module'
        // },

        tooltip: {
            valueDecimals: 2
        },

        xAxis: {
            type: 'linear'
        },

        series: [{
                data: dataAltitude,
                lineWidth: 0.5,
                name: 'Altitude'
            },
            {
                data: dataSpeed,
                lineWidth: 0.5,
                name: 'Speed'
            }
        ]
    });

</script>
