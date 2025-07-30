var options = {
              series: [1, 2, 0, 1],
              chart: {
              width: 380,
              type: 'pie',
            },
            labels: ['Leave', 'Overtime', 'Late', 'Absent'],
            responsive: [{
              breakpoint: 480,
              options: {
                chart: {
                  width: 200
                },
                legend: {
                  position: 'bottom'
                }
              }
            }]
            };

            var chart = new ApexCharts(document.querySelector("#pie-chart"), options);
            chart.render();