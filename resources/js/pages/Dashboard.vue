<template>
  <v-app>
    <h3 class="subheading grey--text">Dashboard</h3>
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
                // this.cso_profile_list = response.data;
                // this.loadCSOProfile = false;
                
                // Find all legends first 
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
                    ...this.CSOProfileChartOptions,
                    labels: labels,
                }
            })

            // CSOProfileAccreditationBodiesSeries:
            // CSOProfileAccreditationBodiesChartOptions: 
        },
        assessment(){
            // lro_assesment -< lro_assessment_sub
        
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
        series: [{
            data: [400, 430, 448, 470, 540, 580, 690, 1100, 1200, 1380]
        }],
        chartOptions: {
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
        
          
 
        
    }),
  
}
</script>
