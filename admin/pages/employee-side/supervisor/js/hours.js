var options = {
              series: [{
            //   name: 'Income',
            //   data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
            // }, {
            //   name: 'Expense',
            //   data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
            // }, {
              name: 'Time Taken',
              data: [0, 0, 10, 7, 9,]
            }],
              chart: {
              type: 'bar',
              height: 350
            },
            plotOptions: {
              bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
              },
            },
            dataLabels: {
              enabled: false
            },
            stroke: {
              show: true,
              width: 2,
              colors: ['transparent']
            },
            xaxis: {
              categories: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
            },
            yaxis: {
              title: {
                text: 'Hours'
              }
            },
            fill: {
              opacity: 1
            },
            tooltip: {
              y: {
                formatter: function (val) {
                  return " " + val + " hours"
                }
              }
            }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();