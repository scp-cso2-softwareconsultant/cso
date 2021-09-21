<template>
  <v-app>
    <h3 class="subheading grey--text">Dashboard</h3>
    <div class="card p-md-5">
        <h4 class="subheading card-text ">CSO² Indicator</h4>
        <div class="card-body ">
            <!-- <h5 class="card-title"> Responsible Organization </h5> -->
            <p class="card-text row justify-content-md-center">
                <apexchart type="pie" width="380" :options="CSOIndicatorChartOptions" :series="CSOIndicatorSeries"></apexchart>
            </p>
            <p class="card-text text-center">
                <small class="text-muted">
                    <v-select chips v-on:change="CSO2IndicatorsChart()" v-model="editedItem.CSO2Indicators" :items="responsibleOrganization" class="p-3" label="Category *" dense ></v-select>                     
                </small>
            </p>
        </div>
    </div>
  
    
    <div class="card p-md-5">
        <h4 class="subheading card-text "> CSO and CSO Network Members Profile</h4>
        <v-card class="ma-1">
            <v-list-item  >
                <v-list-item-content>
                    <div class="card-group">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"> Types of Organization </h5>
                                    <p class="card-text">
                                       <apexchart type="donut" width="380" :options="CSOProfileTypesOfOrganizationChartOptions" :series="CSOProfileTypesOfOrganizationSeries"></apexchart>
                                    </p>
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
                                    <p class="card-text"> Securities and Exchange Commission (SEC) 58% </p>
                                    <p class="card-text"> LGU Development Council 21 </p>
                                    <p class="card-text"> Department of Social Welfare and Development 16% </p>
                                </div>
                                
                            </div>
                        </div>
                </v-list-item-content>
            </v-list-item>
        </v-card>
        <v-flex >
            <v-card class="ma-1">
                <v-list-item  >
                    <v-list-item-content>
                        <h5 class="card-title"> Primary Stakeholders  </h5>
                        <div class="text-center">
                            <apexchart  type="bar" height="350" :options="CSOProfilePrimaryStakeholderChartOptions" :series="CSOProfilePrimaryStakeholderSeries"></apexchart>
                        </div>
                    </v-list-item-content>
                </v-list-item>
            </v-card>
        </v-flex>
    </div>
   
    
   

    <div class="card p-md-5">
        <h4 class="subheading card-text ">Assessment</h4>
        <div class="card-body ">
            <p class="card-text row justify-content-md-center">
              <apexchart type="radar" height="350" :options="assessmentSubDomainPerYearChartOptions" :series="assessmentSubDomainPerYearSeries"></apexchart>
            </p>
           
        </div>
    </div>
    

    <div class="card p-md-5">
        <h4 class="subheading card-text ">  Finance Tracker </h4>
        <v-flex >
            <v-card class="ma-1">
                <v-list-item  >
                    <v-list-item-content>
                        <h5 class="card-title"> Budget vs Actual Expenditures  </h5>
                        <div class="text-center">
                            <apexchart type="line" height="350" :options="financeTrackerBudgetChartOptions" :series="financeTrackerBudgetSeries"></apexchart>
                        </div>
                    </v-list-item-content>
                </v-list-item>
            </v-card>
        </v-flex>
        <v-flex >
            <v-card class="ma-1">
                <v-list-item  >
                    <v-list-item-content>
                        <h5 class="card-title"> Burn Rate </h5>
                        <div class="text-center">
                           <apexchart type="bar" height="350" :options="burnRateChartOptions" :series="burnRateSeries"></apexchart>
                        </div>
                    </v-list-item-content>
                </v-list-item>
            </v-card>
        </v-flex>
    </div>
    <div class="card p-md-5">
        <h4 class="subheading card-text ">Project Tracking Document</h4>
        <div class="card-body ">
            <p class="card-text">
                <apexchart type="bar" height="380" :options="projectTrackingDocumentChartOptions" :series="projectTrackingDocumentSeries"></apexchart>
            </p>
        </div>
    </div>
    
   
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
            document.title = "SCP: CSO² Project | Dashboard"
            this.CSO2IndicatorsChart();
            this.CSOProfile();
            this.assessment();
            this.financeTracker();
            this.ProjectTrackingDocument();

            axios.get("/get-lead-organization").then((res)=>{
                this.responsibleOrganization = res.data
            })

            this.editedItem.CSO2Indicators =  this.responsibleOrganization[0];
        },
        
        CSO2IndicatorsChart(){
            axios.get("/get-indicator-status").then(response => {
                let labels = [];
                const data =  response.data;
                for( let i = 0 ; i <  data.length ; i ++) labels.push( data[i].value );
                this.CSOIndicatorChartOptions = { ...this.CSOIndicatorChartOptions ,  labels: labels };
                axios.get('/dashboard-cso-indicator').then( response => {
                    this.CSOIndicatorSeries = new Array( this.CSOIndicatorChartOptions .labels.length ).fill(0);
                    const data =  response.data;
                    const selectedCategory =  this.editedItem.CSO2Indicators? this.editedItem.CSO2Indicators : 'lead SCP'; 
                    for( let i = 0 ; i < data.length ; i ++)
                        if( data[i].cso_lead_organization === selectedCategory )
                            this.CSOIndicatorSeries[this.CSOIndicatorChartOptions.labels.indexOf(data[i].cso_status) ]+=1;                            
                })
            });
        },
        
        async CSOProfile(){
            var response = await axios.get('/dashboard-cso-profile')
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

                console.log(this.CSOProfilePrimaryStakeholderSeries[0].data)
                this.CSOProfilePrimaryStakeholderSeries[0] = { data : new Array(6).fill(0) }

        //         CSOProfilePrimaryStakeholderSeries: [{data: [21, 40, 60, 35, 12, 40]}]
                console.log(this.CSOProfilePrimaryStakeholderSeries[0].data)
                for( let i = 0; i < data.length ; i++){
                        let insertIndex = this.CSOProfilePrimaryStakeholderChartOptions.xaxis.categories.indexOf(data[i].cso_stakeholders)
                        this.CSOProfilePrimaryStakeholderSeries[0].data[insertIndex]+= 1;                        
                }

                console.log(this.CSOProfilePrimaryStakeholderSeries[0].data)

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
    mounted (){
    },
    data: ()=>({
        editedItem:{
            CSO2Indicators: 'lead SCP'
        },
        responsibleOrganization: [],
        CSOIndicatorSeries: [1,1,1,1,1],
        CSOIndicatorChartOptions: {
            colors:['#ff9800', '#2196f3', '#4caf50','#f44336','#9e9e9e'],
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
            data: [1,1,1,1,1,1]
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
                categories: [
                    "local policy makers", 
                    "private sector support organizations and CSRs", 
                    "peer CSOs or related networks", 
                    "larger CSOs/CSO Network in Manila, Cebu or Davao", 
                    "local researchers and scholars",
                    "potential donors"],
            }
        },
        
        assessmentSubDomainPerYearSeries: [{
            name: 'Series 1',
            data: [80, 50, 30, 40, 100, 20],
        }],
        assessmentSubDomainPerYearChartOptions: {
            chart: {
                height: 450,
                type: 'radar',
            },
            title: {
                text: 'average of SUBDOMAIN, per YEAR'
            },
            xaxis: {
              categories: ['January', 'February', 'March', 'April', 'May', 'June']
            }
        },
        
        financeTrackerBudgetSeries: [{
                name: 'Approved Budget',
                type: 'column',
                data: [1.4, 2, 2.5, 1.5, 2.5, 2.8, 3.8, 4.6]
            }, {
                name: 'Actual Expenditure',
                type: 'column',
                data: [1.1, 3, 3.1, 4, 4.1, 4.9, 6.5, 8.5]
            },  {
                name: 'Budget Remaining',
                type: 'column',
                data: [1.1, 3, 3.1, 4, 4.1, 4.9, 6.5, 8.5]
            },
            {
                name: 'Burn rate',
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
                text: 'Budget vs Actual Expenditures',
                align: 'center',
                offsetX: 110
            },
            xaxis: {
                categories: [1, 2, 3, 4, 5, 6, 7, 8],
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
                    text: "Budget",
                    style: {
                        color: '#008FFB',
                    }
                },
                tooltip: {
                    enabled: true
                }
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
            name: 'Burn Rate (1st Liq)',
            data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
        },{
            name: 'Burn Rate (2st Liq)',
            data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
        },{
            name: 'Burn Rate (3st Liq)',
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
                categories: ['AHA!BD', "PICPA", "AteneoCORD"],
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
            data: [10, 2 , 30, 0, 0, 0]
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
                },
                
            },
            xaxis: {
                min: 0,
                max: 100,
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
                categories: [
                    "Progress bar of days completed",
                    "Progress bar of burn rate",
                    "Progress bar for Objective 1",
                    "Progress bar for Objective 2",
                    "Progress bar for Objective 3",
                    "Progress bar for Objective 4"
                ],
            },
            yaxis: {
                labels: {
                    show: false
                }
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