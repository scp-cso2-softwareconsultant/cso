<template>
  <v-app>
    <h3 class="subheading grey--text">Dashboard</h3>
    <v-flex >
        <v-card class="ma-1">
            <v-list-item  >
                <v-list-item-content>
                    <div class="card-group">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"> Responsible Organization </h5>
                                    <p class="card-text">
                                        <apexchart type="pie" width="380" :options="CSOIndicatorChartOptions" :series="CSOIndicatorSeries"></apexchart>
                                    </p>
                                    <p class="card-text"><small class="text-muted">
                                        <v-select v-on:change="CSO2IndicatorsChart()" v-model="editedItem.CSO2Indicators" :items="responsibleOrganization" class="p-3" label="Category *" dense ></v-select> 
                                    
                                    </small></p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">  Top 3 Accreditation Bodies </h5>
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-2">
                                            <div class="card-box bg-red">
                                                <div class="inner">
                                                    <h3> 82% </h3>
                                                    <h5> CSO</h5>
                                                </div>
                                                <div class="icon">
                                                    <i class="fa fa-users"></i>
                                                </div>
                                                <a href="#" class="card-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="card-box bg-orange">
                                                <div class="inner">
                                                    <h3> 16%</h3>
                                                    <h5> Social Enterprise </h5>
                                                </div>
                                                <div class="icon">
                                                    <i class="fa fa-user-plus" aria-hidden="true"> </i>
                                                </div>
                                                <a href="#" class="card-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="card-box bg-green">
                                                <div class="inner">
                                                    <h3> 2% </h3>
                                                    <h5> Academe </h5>
                                                </div>
                                                <div class="icon">
                                                    <i class="fa fa-money" aria-hidden="true"></i>
                                                </div>
                                                <a href="#" class="card-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                </div>
                            </div>
                        </div>
                </v-list-item-content>
            </v-list-item>
        </v-card>
    </v-flex>
   
 
   
    <v-flex >
        <v-card class="ma-1">
            <v-list-item  >
                <v-list-item-content>
                    <div class="overline text-right"> CSO2 Indicators </div>
                    <div class="text-center">
                        <apexchart  type="bar" height="350" :options="CSOProfilePrimaryStakeholderChartOptions" :series="CSOProfilePrimaryStakeholderSeries"></apexchart>
                    </div>
                </v-list-item-content>
            </v-list-item>
        </v-card>
    </v-flex>
    <v-flex>
        <v-card class="ma-1">
            <v-list-item  >
                <v-list-item-content>
                     <div class="card-group">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"> Responsible Organization </h5>
                                <p class="card-text"><small class="text-muted">
                                <apexchart type="donut" width="380" :options="CSOProfileTypesOfOrganizationChartOptions" :series="CSOProfileTypesOfOrganizationSeries"></apexchart>
                                </small></p>
                            </div>
                        </div>
                    
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">  Top 3 Accreditation Bodies </h5>
                                <apexchart type="radar" height="350" :options="assessmentSubDomainPerYearChartOptions" :series="assessmentSubDomainPerYearSeries"></apexchart>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                    </div>
                </v-list-item-content>
            </v-list-item>
        </v-card>
    </v-flex>

    <v-flex >
        <v-card class="ma-1">
            <v-list-item  >
                <v-list-item-content>
                    <div class="overline text-right"> CSO2 Indicators </div>
                    <div class="text-center">
                       <apexchart type="line" height="350" :options="financeTrackerBudgetChartOptions" :series="financeTrackerBudgetSeries"></apexchart>
                    </div>
                </v-list-item-content>
            </v-list-item>
        </v-card>
    </v-flex>
    
    <v-flex>
        <v-card class="ma-1">
            <v-list-item  >
                <v-list-item-content>
                     <div class="card-group">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"> Responsible Organization </h5>
                                <p class="card-text"><small class="text-muted">
                                <apexchart type="bar" height="350" :options="burnRateChartOptions" :series="burnRateSeries"></apexchart>
                                </small></p>
                            </div>
                        </div>
                    
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">  Top 3 Accreditation Bodies </h5>
                                 <apexchart type="bar" height="380" :options="projectTrackingDocumentChartOptions" :series="projectTrackingDocumentSeries"></apexchart>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                    </div>
                </v-list-item-content>
            </v-list-item>
        </v-card>
    </v-flex>
   
  <!--
    <v-flex sm6>
        <v-card class="ma-1">
            <v-list-item  >
                <v-list-item-content>
                    <div class="overline text-right"> CSO2 Indicators </div>
                    <v-list-item-title class="headline text-right" >
                    <v-select v-on:change="CSO2IndicatorsChart()" v-model="editedItem.CSO2Indicators" :items="responsibleOrganization" class="p-3" label="Category *" dense ></v-select> 
                    </v-list-item-title>
                    <div><v-divider></v-divider></div>
                    <apexchart type="pie" width="380" :options="CSOIndicatorChartOptions" :series="CSOIndicatorSeries"></apexchart>
                </v-list-item-content>
            </v-list-item>
        </v-card>
    </v-flex>

    <v-card >
        <v-card-text>
            <v-container dense >
                <v-row>
                    <v-col cols="12" lg="6" >
                        <div id="chartRadar">
                            <apexchart type="pie" width="380" :options="CSOIndicatorChartOptions" :series="CSOIndicatorSeries"></apexchart>
                        </div>
                    </v-col>
                    <v-col cols="12" lg="6" >
                        <div id="chartGroup">
                            <apexchart type="pie" width="380" :options="CSOIndicatorChartOptions" :series="CSOIndicatorSeries"></apexchart>
                        </div>
                    </v-col>
                    
                    
                </v-row>
            </v-container>
        </v-card-text>
    </v-card>

    <v-flex sm6>
        <v-card class="ma-1">
            <v-list-item  >
                <v-list-item-content>
                    <div class="overline text-right"> CSO2 Indicators </div>
                    <v-list-item-title class="headline text-right" >
                    </v-list-item-title>
                    <div><v-divider></v-divider></div>
                  
        
                    <apexchart type="pie" width="380" :options="CSOProfileAccreditationBodiesChartOptions" :series=" CSOProfileAccreditationBodiesSeries"></apexchart>
                </v-list-item-content>
            </v-list-item>
        </v-card>
    </v-flex>

    <v-flex sm6>
        <v-card class="ma-1">
            <v-list-item  >
                <v-list-item-content>
                    <div class="overline text-right"> CSO2 Indicators </div>
                    <v-list-item-title class="headline text-right" >
                    </v-list-item-title>
                    <div><v-divider></v-divider></div>
                    <apexchart type="pie" width="380" :options="CSOProfileTypesOfOrganizationChartOptions" :series="CSOProfileTypesOfOrganizationSeries"></apexchart>
                </v-list-item-content>
            </v-list-item>
        </v-card>
    </v-flex>
    <v-flex sm6>
        <v-card class="ma-1">
            <v-list-item  >
                <v-list-item-content>
                    <div class="overline text-right"> CSO2 Indicators </div>
                    <v-list-item-title class="headline text-right" >
                    </v-list-item-title>
                    <div><v-divider></v-divider></div>
                    <apexchart type="bar" height="350" :options="CSOProfilePrimaryStakeholderChartOptions" :series="CSOProfilePrimaryStakeholderSeries"></apexchart>
                </v-list-item-content>
            </v-list-item>
        </v-card>
    </v-flex>
    <v-flex sm6>
        <v-card class="ma-1">
            <v-list-item  >
                <v-list-item-content>
                    <div class="overline text-right"> CSO2 Indicators </div>
                    <v-list-item-title class="headline text-right" >
                    </v-list-item-title>
                    <div><v-divider></v-divider></div>
                    <apexchart type="radar" height="350" :options="assessmentSubDomainPerYearChartOptions" :series="assessmentSubDomainPerYearSeries"></apexchart>
                </v-list-item-content>
            </v-list-item>
        </v-card>
    </v-flex>
    <v-flex sm6>
        <v-card class="ma-1">
            <v-list-item  >
                <v-list-item-content>
                    <div class="overline text-right"> CSO2 Indicators </div>
                    <v-list-item-title class="headline text-right" >
                    </v-list-item-title>
                    <div><v-divider></v-divider></div>
                    <apexchart type="line" height="350" :options="financeTrackerBudgetChartOptions" :series="financeTrackerBudgetSeries"></apexchart>
                </v-list-item-content>
            </v-list-item>
        </v-card>
    </v-flex>
    <v-flex sm6>
        <v-card class="ma-1">
            <v-list-item  >
                <v-list-item-content>
                    <div class="overline text-right"> CSO2 Indicators </div>
                    <v-list-item-title class="headline text-right" >
                    </v-list-item-title>
                    <div><v-divider></v-divider></div>
                    <apexchart type="bar" height="350" :options="burnRateChartOptions" :series="burnRateSeries"></apexchart>
                </v-list-item-content>
            </v-list-item>
        </v-card>
    </v-flex>
    <v-flex sm6>
        <v-card class="ma-1">
            <v-list-item  >
                <v-list-item-content>
                    <div class="overline text-right"> CSO2 Indicators </div>
                    <v-list-item-title class="headline text-right" >
                    </v-list-item-title>
                    <div><v-divider></v-divider></div>
                    <apexchart type="bar" height="380" :options="projectTrackingDocumentChartOptions" :series="projectTrackingDocumentSeries"></apexchart>
                </v-list-item-content>
            </v-list-item>
        </v-card>
    </v-flex> 
    
    --> 
  </v-app>
</template>


<script>


// @ is an alias to /src
import VueApexCharts from 'vue-apexcharts';
export default {
    components: {
        apexchart: VueApexCharts,
    },
    methods:{
        initialize () {
            document.title = "CSO | Dashboard"
            this.CSO2IndicatorsChart();
            this.CSOProfile();
            this.assessment();
            this.financeTracker();
            this.ProjectTrackingDocument();
            this.responsibleOrganization = ["lead SCP", "Ateneo CORD", "AHA BD", "PICPA"]
            this.editedItem.CSO2Indicators =  this.responsibleOrganization[0];
            console.log("HEllo world")
        },
        
        CSO2IndicatorsChart(){
            axios.get("/get-indicator-status").then(response => {
                let labels = [];
                const data =  response.data;
                for( let i = 0 ; i <  data.length ; i ++) labels.push( data[i].value );
                this.CSOIndicatorChartOptions = { ...this.CSOIndicatorChartOptions ,  labels: labels };
                axios.get('/cso-indicator' ).then( response => {
                    const series = new Array( this.CSOIndicatorChartOptions .labels.length ).fill(0);
                    const data =  response.data;
                    const selectedCategory =  this.editedItem.CSO2Indicators; 
                    for( let i = 0 ; i < data.length ; i ++)
                        if( data[i].cso_description.includes( selectedCategory  ))
                            series[  this.CSOIndicatorChartOptions.labels.indexOf(data[i].cso_status) ]+=1;
                    this.CSOIndicatorSeries =  series ;
                })
            });
            
        },
        
        CSOProfile(){
            axios.get('/cso-profile').then( response => {
                const data = response.data; 
                let legends = {}; 
                for( let i = 0; i < data.length ; i++)
                    legends[data[i].cso_type] = isNaN(legends[data[i].cso_type] )? 1 :legends[data[i].cso_type]+1;  
                
                let labels = [];
                let series = []; 
                Object.entries(  legends  ).forEach( ([key, value]) =>{
                    labels.push( key );
                    series.push( value );
                    
                });
                this.CSOProfileTypesOfOrganizationSeries = series ;
                this.CSOProfileTypesOfOrganizationChartOptions = {
                    ...this.CSOProfileTypesOfOrganizationChartOptions,
                    labels: labels,
                }
            })

            // CSOProfileAccreditationBodiesSeries:
            // CSOProfileAccreditationBodiesChartOptions: 

            // CSOProfilePrimaryStakeholderSeries
            // CSOProfilePrimaryStakeholderChartOptions
        },
        assessment(){
            // assessmentSubDomainPerYearSeries
            // assessmentSubDomainPerYearChartOptions
        
        },
        financeTracker(){
            // financeTrackerBudgetSeries
            // financeTrackerBudgetChartOptions

            // burnRateSeries
            // burnRateChartOptions
        },
        ProjectTrackingDocument(){
            // projectTrackingDocumentSeries
            // projectTrackingDocumentChartOptions
        },
        generateDayWiseTimeSeries: function(baseval, count, yrange) {
            var i = 0;
            var series = [];
            while (i < count) {
                var x = baseval;
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
        editedItem:{
            CSO2Indicators: 'lead SCP'
        },
        responsibleOrganization: [],
        CSOIndicatorSeries: [44, 55, 13, 43],
        CSOIndicatorChartOptions: {
            chart: {
                width: 380,
                type: 'pie',
            },
            labels: ['lead SCP', 'Ateneo CORD', 'AHA BD', 'PICPA' ],
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
        CSOProfileAccreditationBodiesSeries: [44, 55, 13, 43, 22],
        CSOProfileAccreditationBodiesChartOptions: {
            chart: {
              width: 380,
              type: 'pie',
            },
            labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
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
        CSOProfileTypesOfOrganizationSeries: [44, 55, 13, 43],
        CSOProfileTypesOfOrganizationChartOptions: {
            chart: {
                width: 480,
                type: 'donut',
            },
            labels: ['lead SCP', 'Ateneo CORD', 'AHA BD', 'PICPA' ],
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
        CSOProfilePrimaryStakeholderSeries: [{
            data: [400, 430, 448, 470, 540, 580, 690, 1100, 1200, 1380]
        }],
        CSOProfilePrimaryStakeholderChartOptions: {
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: true,
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: ['South Korea', 'Canada', 'United Kingdom', 'Netherlands', 'Italy', 'France', 'Japan',
                    'United States', 'China', 'Germany'
                ],
            }
        },
        
        assessmentSubDomainPerYearSeries: [{
            name: 'Series 1',
            data: [80, 50, 30, 40, 100, 20],
        }],
        assessmentSubDomainPerYearChartOptions: {
            chart: {
                height: 350,
                type: 'radar',
            },
            title: {
                text: 'Basic Radar Chart'
            },
            xaxis: {
              categories: ['January', 'February', 'March', 'April', 'May', 'June']
            }
        },
        
        financeTrackerBudgetSeries: [{
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

        financeTrackerBudgetChartOptions: {
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
            yaxis: [
            {
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

        burnRateSeries: [{
            name: 'Net Profit',
            data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
        },{
            name: 'Revenue',
            data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
        },{
            name: 'Free Cash Flow',
            data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
        }],
        burnRateChartOptions: {
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
        
        projectTrackingDocumentSeries: [{
            data: [400, 430, 448, 470, 540, 580, 690, 1100, 1200, 1380]
        }],
        projectTrackingDocumentChartOptions: {
            chart: {
                type: 'bar',
                height: 380
            },
            plotOptions: {
                bar: {
                    barHeight: '100%',
                    distributed: true,
                    horizontal: true,
                    dataLabels: {
                        position: 'bottom'
                    },
                }
            },
            colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e', '#f48024', '#69d2e7'  ],
            dataLabels: {
                enabled: true,
                textAnchor: 'start',
                style: {
                    colors: ['#fff']
                },
                formatter: function (val, opt) {
                    return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
                },
                offsetX: 0,
                dropShadow: {
                    enabled: true
                }
            },
            stroke: {
                width: 1,
                colors: ['#fff']
            },
            xaxis: {
                categories: ['South Korea', 'Canada', 'United Kingdom', 'Netherlands', 'Italy', 'France', 'Japan', 'United States', 'China', 'India' ],
            },
            yaxis: {
                labels: {
                    show: false
                }
            },
            title: {
                text: 'Custom DataLabels',
                align: 'center',
                floating: true
            },
            subtitle: {
                text: 'Category Names as DataLabels inside bars',
                align: 'center',
            },
            tooltip: {
                theme: 'dark',
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function () {
                            return ''
                        }
                    }
                }
            }
        },
        
    }),
  
}
</script>
