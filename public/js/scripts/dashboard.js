window.onload = function() {
    $('.select2').select2();

    getChartData();

    $('.chartSelect').on('change', function(e) {
        var year = e.target.options[e.target.selectedIndex].value;
        let type = $(this).closest('.chart').attr('id');
        let companyId = $('#search-client').val();
        getChartData(year, type, companyId);
    });

    $('.companiesSelect').on('change', function (e) {
        let year = $('#company_filing_per_month').find('.chartSelect:first').val();
        let type = $(this).closest('.chart').attr('id');
        let companyId = e.target.options[e.target.selectedIndex].value;

        getChartData(year, type, companyId);
    });

    function getChartData(year = '', type = '', companyId = ''){
        $.ajax({
            type: 'GET',
            data: {
                year: year,
                type: type,
                companyId: companyId,
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/admin/dashboard/get-chart-data',
            success: function(response) {
                var chartData = response.chartData;
                $.each(chartData, function(id, value) {
                    setChartDataById(id, value)
                });
            }
        });
    }

    function setChartDataById(id, value) {
        let mainElement = $('#' + id);
        mainElement.find('canvas:first').remove();
        mainElement.append('<canvas width="200"></canvas>');
        let canvas = mainElement.find('canvas:first')[0];
        let label = mainElement.data('label');
        var ctx = canvas.getContext('2d');
        var data = getDataPerMonth(value);

        //label name, data, color
        var config = createConfig(label, data, '#0574f0');
        new Chart(ctx, config);
    }

    function getDataPerMonth(chartData){
        var data = [];
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        months.forEach(function (month) {
            if(chartData[month] === undefined){
                data.push(0);
            }else {
                data.push(chartData[month]);
            }
        });
        return data;
    }

    function createConfig(label, data,color) {
        return {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: label,
                    backgroundColor: color,
                    borderColor: color,
                    data: data,
                    fill: false,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            userCallback: function(label, index, labels) {
                                // when the floored value is the same as the value we have a whole number
                                if (Math.floor(label) === label) {
                                    return label;
                                }

                            },
                        }
                    }]
                },
            }
        };
    }
};
