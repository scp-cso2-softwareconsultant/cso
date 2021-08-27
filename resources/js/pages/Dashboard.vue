<template>
  <v-app>
    <h3 class="subheading grey--text">Dashboard</h3>
    <v-flex sm6>
        <v-card class="ma-1">
            <v-list-item  >
                <v-list-item-avatar tile class="mt-n7"  >
                    <v-sheet color="green" width="80" height="80" elevation="10">
                    </v-sheet>
                </v-list-item-avatar>
                <v-list-item-content>
                    <div class="overline text-right">Project Tracking document</div>
                    <v-list-item-title class="headline mb-1 text-right" >523614</v-list-item-title>
                    <div><v-divider></v-divider></div>
                    <apexchart type="donut" :options="chartOptions_3" :series="series_3"></apexchart>
                </v-list-item-content>
            </v-list-item>
            <v-card-actions>
            </v-card-actions>
        </v-card>
    </v-flex>

<!--   
    
    <v-flex >
        <v-card class="ma-1">
            <v-list-item  >
                <v-list-item-avatar tile class="mt-n7"  >
                    <v-sheet color="green" width="80" height="80" elevation="10">
                    </v-sheet>
                </v-list-item-avatar>
                
                <v-list-item-content>
                    <div class="overline text-right">CSO2 Indicator</div>
                    <v-list-item-title class="headline mb-1 text-right" >523614</v-list-item-title>
                    <div><v-divider></v-divider></div>
                     <apexchart type="line" height="350" :options="chartOptions_1" :series="series_1"></apexchart>
                </v-list-item-content>
            </v-list-item>
            <v-card-actions>
            </v-card-actions>
        </v-card>
    </v-flex>
    <v-flex >
        <v-card class="ma-1">
            <v-list-item  >
                <v-list-item-avatar tile class="mt-n7"  >
                    <v-sheet color="green" width="80" height="80" elevation="10">
                    </v-sheet>
                </v-list-item-avatar>
                
                <v-list-item-content>
                    <div class="overline text-right">FinancE Tracker</div>
                    <v-list-item-title class="headline mb-1 text-right" >523614</v-list-item-title>
                    <div><v-divider></v-divider></div>
                    <apexchart type="bar" height="350" :options="chartOptions_2" :series="series_2"></apexchart>
                </v-list-item-content>
            </v-list-item>
            <v-card-actions>
            </v-card-actions>
        </v-card>
    </v-flex>
    

    <v-flex >
        <v-card class="ma-1">
            <v-list-item  >
                <v-list-item-avatar tile class="mt-n7"  >
                    <v-sheet color="green" width="80" height="80" elevation="10">
                    </v-sheet>
                </v-list-item-avatar>
                
                <v-list-item-content>
                    <div class="overline text-right">LMS</div>
                    <v-list-item-title class="headline mb-1 text-right" >523614</v-list-item-title>
                    <div><v-divider></v-divider></div>
                    <apexchart type="line" height="160" :options="chartOptions_4" :series="series_4"></apexchart>
                </v-list-item-content>
            </v-list-item>
            <v-card-actions>
            </v-card-actions>
        </v-card>
    </v-flex>
     <v-flex >
        <v-card class="ma-1">
            <v-list-item  >
                <v-list-item-avatar tile class="mt-n7"  >
                    <v-sheet color="green" width="80" height="80" elevation="10">
                    </v-sheet>
                </v-list-item-avatar>
                
                <v-list-item-content>
                    <div class="overline text-right">CSO Profile</div>
                    <v-list-item-title class="headline mb-1 text-right" >523614</v-list-item-title>
                    <div><v-divider></v-divider></div>
                    <apexchart type="area" height="160" :options="chartOptions_5" :series="series_5"></apexchart>
                </v-list-item-content>
            </v-list-item>
            <v-card-actions>
            </v-card-actions>
        </v-card>
    </v-flex>
     <v-flex >
        <v-card class="ma-1">
            <v-list-item  >
                <v-list-item-avatar tile class="mt-n7"  >
                    <v-sheet color="green" width="80" height="80" elevation="10">
                    </v-sheet>
                </v-list-item-avatar>
                
                <v-list-item-content>
                    <div class="overline text-right">Finance</div>
                    <v-list-item-title class="headline mb-1 text-right" >523614</v-list-item-title>
                    <div><v-divider></v-divider></div>
                    
                    <apexchart type="radialBar" height="390" :options="chartOptions_6" :series="series_6"></apexchart>
                </v-list-item-content>
            </v-list-item>
            <v-card-actions>
            </v-card-actions>
        </v-card>
    </v-flex>
     -->
    
  </v-app>
</template>


<script>

// this.generateDayWiseTimeSeries(new Date('11 Feb 2017').getTime(), 20, { min: 10, max: 60  }) }
// @ is an alias to /src
import VueApexCharts from 'vue-apexcharts';
export default {
    components: {
        apexchart: VueApexCharts,
    },
    methods:{
        initialize () {
           
            this.series_4 = [{ data:  this.generateDayWiseTimeSeries(new Date('11 Feb 2017').getTime(), 10, { min: 10, max: 20  }) }]
            this.series_5= [{ data:  this.generateDayWiseTimeSeries(new Date('11 Feb 2017').getTime(),10, { min: 10, max: 20  }) }]
            this.CSO2IndicatorsChart();
            this.CSOProfile();
            this.assessment();
            this.financeTracker();
            this.ProjectTrackingDocument();
        },
        CSO2IndicatorsChart(){

        },
        CSOProfile(){

        },
        assessment(){
            
        },
        financeTracker(){

        },
        ProjectTrackingDocument(){

        },
        generateDayWiseTimeSeries: function(baseval, count, yrange) {
            var i = 0;
            var series = [];
            while (i < count) {
                var x = baseval;
                console.log( x)
                var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
                series.push([i, y]);
                baseval += 86400;
                i++;
            }
            return series;
        }
    },
    created (){
        this.initialize()
    },
    data: ()=>({

        series_1: [{
            name: 'Income',
            type: 'column',
            data: [1.4, 2, 2.5, 1.5, 2.5, 2.8, 3.8, 4.6]
        }, {
            name: 'Cashflow',
            type: 'column',
            data: [1.1, 3, 3.1, 4, 4.1, 4.9, 6.5, 8.5]
        }, {
            name: 'Revenue',
            type: 'line',
            data: [20, 29, 37, 36, 44, 45, 50, 58]
        }],
        chartOptions_1: {
            chart: {
                height: 350,
                type: 'line',
                stacked: false
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: [1, 1, 4]
            },
            title: {
                text: 'XYZ - Stock Analysis (2009 - 2016)',
                align: 'left',
                offsetX: 110
            },
            xaxis: {
                categories: [2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016],
            },
            yaxis: [{
                axisTicks: {
                    show: true,
                },
                axisBorder: {
                    show: true,
                    color: '#008FFB'
                },
                labels: {
                    style: {
                        colors: '#008FFB',
                    }
                },
                title: {
                    text: "Income (thousand crores)",
                    style: {
                        color: '#008FFB',
                    }
                },
                tooltip: {
                    enabled: true
                }
                },
                {
                    seriesName: 'Income',
                    opposite: true,
                    axisTicks: {
                    show: true,
                    },
                    axisBorder: {
                    show: true,
                    color: '#00E396'
                    },
                    labels: {
                    style: {
                        colors: '#00E396',
                    }
                    },
                    title: {
                    text: "Operating Cashflow (thousand crores)",
                    style: {
                        color: '#00E396',
                    }
                    },
                },
                {
                    seriesName: 'Revenue',
                    opposite: true,
                    axisTicks: {
                        show: true,
                    },
                    axisBorder: {
                        show: true,
                        color: '#FEB019'
                    },
                    labels: {
                        style: {
                            colors: '#FEB019',
                        },
                    },
                    title: {
                        text: "Revenue (thousand crores)",
                        style: {
                            color: '#FEB019',
                        }
                    }
                }],
            tooltip: {
              fixed: {
                enabled: true,
                position: 'topLeft', // topRight, topLeft, bottomRight, bottomLeft
                offsetY: 30,
                offsetX: 60
              },
            },
            legend: {
              horizontalAlign: 'left',
              offsetX: 40
            }
        },

        //===================================================================================

        series_2: [{
                name: 'Net Profit',
                data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
            }, {
                name: 'Revenue',
                data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
            }, {
                name: 'Free Cash Flow',
                data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
        }],
        chartOptions_2: {
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
                categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
            },
            yaxis: {
                title: {
                    text: '$ (thousands)'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "$ " + val + " thousands"
                    }
                }
             }
        },
    // ====================================================================================================================
     
        series_3: [44, 55, 41, 17, 15],
        chartOptions_3: {
            chart: {
                type: 'donut',
            },
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
        },
    //======================================================================================================================
        series_4: [{ data:  '' }],
        chartOptions_4: {
            chart: {
                id: 'fb',
                group: 'social',
                type: 'line',
                height: 160
            },
        colors: ['#008FFB'],
            yaxis: {
                labels: {
                    minWidth: 40
                }
            }
        },
        series_5: [{ data:  "" }],
        chartOptions_5: {
            chart: {
                id: 'yt',
                group: 'social',
                type: 'area',
                height: 160
            },
            colors: ['#00E396'],
            yaxis: {
                labels: {
                    minWidth: 40
                }
            }
        },
        series_6: [76, 67, 61, 90],
        chartOptions_6: {
            chart: {
                    height: 390,
                    type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    offsetY: 0,
                    startAngle: 0,
                    endAngle: 270,
                    hollow: {
                        margin: 5,
                        size: '30%',
                        background: 'transparent',
                        image: undefined,
                    },
                    dataLabels: {
                        name: {
                            show: false,
                        },
                        value: {
                            show: false,
                        }
                    }
                }
            },
            colors: ['#1ab7ea', '#0084ff', '#39539E', '#0077B5'],
            labels: ['Vimeo', 'Messenger', 'Facebook', 'LinkedIn'],
            legend: {
                show: true,
                floating: true,
                fontSize: '16px',
                position: 'left',
                offsetX: 160,
                offsetY: 15,
                labels: {
                    useSeriesColors: true,
                },
                markers: {
                    size: 0
                },
                formatter: function(seriesName, opts) {
                    return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex]
                },
                itemMargin: {
                    vertical: 3
                }
            },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: {
                        show: false
                        }
                    }
                }]
          },
        
    }),
    //     return {
    //         team:[],
    //         radarSeries: [
    //             {
    //                 name: '2013',
    //                 data: [3, 2.6, 2.8, 3.5, 3, 2.5,2.5,2.9],
    //             },
    //             {
    //                 name: '2014',
    //                 data: [1.8, 2.2, 2.6, 2.8, 2, 2.2, 2.2, 2.8],
    //             }],
    //         radarChartOptions: {
    //             chart: {
    //                 height: 350,
    //                 type: 'radar',
    //             },
    //             title: {
    //                 text: 'Graph View'
    //             },
    //             xaxis: {
    //                 categories: ['Results', 'Standards', 'Delivery', 'Reach', 'Target', 'Learning','Resources','Social']
    //             }
    //         },

    //         groupSeries: [{
    //             name: 'Actual',
    //             data: [90000, 120000, 80000]
    //         }, {
    //             name: 'Variance',
    //             data: [310000,280000,320000]
    //         }],
    //         groupChartOptions: {
    //             chart: {
    //                 type: 'bar',
    //                 height: 150
    //             },
    //             title: {
    //                 text: 'Finance Tracker'
    //             },
    //             plotOptions: {
    //                 bar: {
    //                     horizontal: true,
    //                     dataLabels: {
    //                         position: 'top',
    //                     },
    //                 }
    //             },
    //             dataLabels: {
    //                 enabled: true,
    //                 offsetX: -6,
    //                 style: {
    //                     fontSize: '12px',
    //                     colors: ['#fff']
    //                 }
    //             },
    //             stroke: {
    //                 show: true,
    //                 width: 1,
    //                 colors: ['#fff']
    //             },
    //             tooltip: {
    //                 shared: true,
    //                 intersect: false
    //             },
    //             xaxis: {
    //                 categories: ['AHA!BD', 'PICPA', 'AteneoCORD'],
    //             },
    //         },

    //         series: [{
    //             data: [21, 22, 10, 28, 16, 21, 13]
    //         }],
    //         chartOptions: {
    //             chart: {
    //                 height: 350,
    //                 type: 'bar',
    //                 events: {
    //                     click: function(chart, w, e) {
    //                         // console.log(chart, w, e)
    //                     }
    //                 }
    //             },
    //             title: {
    //                 text: 'Sign-In Attendance'
    //             },
    //             // colors: colors,
    //             plotOptions: {
    //                 bar: {
    //                     columnWidth: '45%',
    //                     distributed: true,
    //                 }
    //             },
    //             dataLabels: {
    //                 enabled: false
    //             },
    //             legend: {
    //                 show: false
    //             },
    //             xaxis: {
    //                 categories: [
    //                     // ['Event A', 'Doe'],
    //                     'Event A',
    //                     'Event B',
    //                     'Event C',
    //                     'Event D',
    //                     'Event E',
    //                     'Event F',
    //                     'Event G',
    //                     'Event H'
    //                 ],
    //                 labels: {
    //                     style: {
    //                         // colors: colors,
    //                         fontSize: '12px'
    //                     }
    //                 }
    //             }
    //         },
    //     }
    // },
}
</script>
