<template>
    <v-app>
        <h3 class="subheading grey--text">Project Tracking Document</h3>
        <div class="overline text-left grey--text">
            CAPACITATING STRATEGIC ORGANIZATIONS TO STRENGTHEN THE CIVIL SOCIETY
            ORGANIZATION SECTOR (CSO2)
        </div>
        <v-container>
            <v-row>
                <v-col cols="12" sm="6" md="6">
                    <v-card class="ma-1 mt-6">
                        <v-list-item>
                            <v-list-item-content>
                                <div class="overline text-left">
                                    Start Date :<strong>
                                        {{ editedItem.startDate }}
                                    </strong>
                                </div>
                                <div class="overline text-left">
                                    Current Date :
                                    <strong> {{ editedItem.curDate }} </strong>
                                </div>
                                <div class="overline text-left">
                                    Days Completed :<strong>
                                        {{ editedItem.daysCompleted }}
                                    </strong>
                                </div>
                                <div class="overline text-left">
                                    Days Left :
                                    <strong> {{ editedItem.daysLeft }} </strong>
                                </div>
                                <div class="overline text-left">
                                    End Date: <strong> {{  editedItem.endDate }} </strong>
                                </div>
                            </v-list-item-content>
                        </v-list-item>
                    </v-card>
                    <v-card class="ma-1 mt-6">
                        <v-list-item>
                            <v-list-item-content>
                                <div class="overline text-left">
                                    Total Budget (USD) :
                                    <strong>
                                        <vue-numeric currency="$" separator="," read-only v-model="editedItem.totalBudget" ></vue-numeric
                                    ></strong>
                                </div>
                                <div class="overline text-left">
                                    <vuetify-money
                                        v-model="editedItem.spent_to_date"
                                        label="Spent To Date : "
                                        v-bind:options="options"
                                        @input="setBurnRate();update_dashboard();"
                                    />
                                </div>
                                <div class="overline text-left">
                                    Remaining:
                                    <strong>
                                        <vue-numeric
                                            currency="$"
                                            separator="."
                                            read-only
                                            v-model="editedItem.remaining"
                                        ></vue-numeric>
                                    </strong>
                                </div>
                                <div class="overline text-left">
                                    Burn rate: <strong>{{  editedItem.burnRate }} % </strong>
                                </div>
                                <div class="overline text-left">
                                    Percent Complete : <strong>{{  editedItem.percentComplete }} % </strong>
                                </div>
                            </v-list-item-content>
                        </v-list-item>
                    </v-card>
                </v-col>
            </v-row>
            <div class="card p-md-5">
                <h4 class="subheading card-text">Project Tracking Document</h4>
                <div class="card-body">
                    <p class="card-text">
                    <apexchart
                        type="bar"
                        height="380"
                        :options="projectTrackingDocumentChartOptions"
                        :series="projectTrackingDocumentSeries"
                    ></apexchart>
                    </p>
                </div>
            </div>
            
            <v-btn
                v-show="crud_guard.update"
                class="ma-2"
                color="primary"
                block
                :loading="btnLoader"
                @click="save"
            >
                Save
            </v-btn>
            <ProjectTrackingDocumentModal/>
        </v-container>
    </v-app>
</template>
<script>
import VueNumeric from "vue-numeric";
const days360 = require("days360");
import ProjectTrackingDocumentModal from './ProjectTrackingModal'
import VueApexCharts from "vue-apexcharts";

export default {
    components: {
        VueNumeric,
        ProjectTrackingDocumentModal
    },
    data() {
        return {
            canBeSaved: false,
            percent_complete:0,
            crud_guard : {
                create: 0,
                delete: 0,
                download: 0,
                export: 0,
                print: 0,
                read: 0,
                update: 0,
                upload: 0,
                view: 0,
            },
            editedItem:{
                burnRate: "",
                startDate: "",
                curDate: "",
                endDate: "",
                daysCompleted: 0,
                spent_to_date: 0,
                daysLeft: 0,
                percentComplete: 0,
                remaining: 0,
                totalBudget: 0, 
                objective_1:0,
                objective_2:0,
                objective_3:0,
            },
            defaultItem:{
                burnRate: "",
                startDate: "",
                curDate: "",
                endDate: "",
                daysCompleted: 0,
                spent_to_date: 0,
                daysLeft: 0,
                percentComplete: 0,
                remaining: 0,
                totalBudget: 0, 
                objective_1:0,
                objective_2:0,
                objective_3:0,
                
            },
            btnLoader: false,
            options: {
                locale: "en-US",
                prefix: "₱",
                suffix: "",
                length: 11,
                precision: 0
            },
        projectTrackingDocumentSeries: [{
            data: [10, 2, 30, 0, 0, 0]
        }],
        projectTrackingDocumentChartOptions: {
            chart: {
                type: "bar",
                height: 380,
            },
            plotOptions: {
                bar: {
                barHeight: "100%",
                distributed: true,
                horizontal: true,
                dataLabels: {
                    position: "bottom",
                },
                },
            },
            
            colors: [
                "#33b2df",
                "#546E7A",
                "#d4526e",
                "#13d8aa",
                "#A5978B",
                "#2b908f",
                "#f9a3a4",
                "#90ee7e",
                "#f48024",
                "#69d2e7",
            ],
            dataLabels: {
                enabled: true,
                textAnchor: "start",
                style: {
                colors: ["#000"],
                },
                formatter: function (val, opt) {
                return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val;
                },
                offsetX: 0,
                dropShadow: {
                enabled: true,
                },
            },
            stroke: {
                width: 1,
                colors: ["#fff"],
            },
            xaxis: {
                min: 0,
                max: 100,
                categories: [
                    "Progress bar of days completed",
                    "Progress bar of burn rate",
                    "Progress bar for Objective 1",
                    "Progress bar for Objective 2",
                    "Progress bar for Objective 3",
                ],
            },
            yaxis: {
                labels: {
                    show: false,
                },
            },
            tooltip: {
                theme: "dark",
                x: {
                    show: false,
                },
                y: {
                    title: {
                            formatter: function () {
                                return "";
                            },
                        },
                    },
                },
            }
        };
    },
    methods: {
        initialize() {

            document.title = "SCP: CSO² Project | Project Tracking Document";
            axios.get('/user-roles-permission').then( response => {
                const moduleName = 'ProjectTrackingDocuments';
                const data = response.data; 
                for (const key in  data ){
                    if( data[key].name == moduleName ){
                        const crud_guard = data[key].crud_guard[0];
                        this.canBeSaved = crud_guard.create; 
                        if( crud_guard.view == 0 ) this.$router.push("dashboard");
                        else this.crud_guard =  crud_guard ;
                        break;
                    }
                }
            })
            
            this.getData();  
        },
        onlyNumber ($event) {; //keyCodes value
            let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
            if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
                $event.preventDefault();
            }
        },    
        async save() {
            if(this.canBeSaved && this.crud_guard.update ){
                this.btnLoader = true;
                axios.post("/save-project-tracking-document", { data: JSON.stringify(this.editedItem) }).then(response => {
                    this.btnLoader = false;
                    this.initialize();
                })
            }
        },

        getData(){
            axios.get('/get-project-tracking-document').then(response =>{
                const data = response.data;
                this.editedItem =  data;
            })
            axios.get('/dashboard-finance-tracker').then(response=>{
                const data =  response.data;
                var total_budget = 0;
                for( const index in data ){
                    const finance = data[index];
                    total_budget += parseFloat(finance.finance_budget );
                }
                this.editedItem.totalBudget = total_budget;
                this.init();
            })
            this.update_dashboard();
        },
        update_dashboard(){
            axios.get("/dashboard-cso-indicator").then((response)=>{
                const data = response.data;
                var objective_1 = 0;
                var objective_2 = 0;
                var objective_3 = 0;
                var objective_4 = 0;
                var total_activities = 0;
                for( const name in data ){
                    if( data[name].cso_category == 'Activity' && data[name].cso_status == "Completed" ){
                        objective_1 += data[name].objective_1;
                        objective_2 += data[name].objective_2;
                        objective_3 += data[name].objective_3;
                    }
                    total_activities += 1;
                }
                this.editedItem.objective_1 = objective_1 / total_activities * 100,
                this.editedItem.objective_2 = objective_2 / total_activities * 100,
                this.editedItem.objective_3 = objective_3 / total_activities * 100,
                this.setBurnRate();
                this.projectTrackingDocumentSeries = [{
                    data:[  
                        this.editedItem.percentComplete,
                        this.editedItem.burnRate,
                        this.editedItem.objective_1,  
                        this.editedItem.objective_2,
                        this.editedItem.objective_3,
                    ]
                }]
            })
        },
        setBurnRate() {
            if (!isNaN(Number.parseFloat(this.editedItem.spent_to_date))) {
                this.editedItem.burnRate = (  (Number.parseFloat(this.editedItem.spent_to_date) / this.editedItem.totalBudget) * 100 ).toFixed(2) ;
                this.computeRemaining();
                return;
            }
            this.editedItem.burnRate = "-.-%";
        },

        getParsedDate(date) {
            const t = date;
            const dd = ('0' + t.getDate()).slice(-2);
            const mm = ('0' + (t.getMonth() + 1)).slice(-2);
            const yyyy = t.getFullYear();
            const time = `${mm}/${dd}/${yyyy}`;
            return time;
        },

        getRealDate(date) {
            return new Date(date);
        },
        computeRemaining() {
            this.editedItem.remaining = this.editedItem.totalBudget - this.editedItem.spent_to_date;
            if( isNaN(Number.parseFloat( this.editedItem.remaining))  ){
                this.editedItem.remaining  = 0.0;
            }
        },
        init() {
            this.setBurnRate();
            this.editedItem.curDate = this.getParsedDate(new Date());
            this.editedItem.startDate = this.getParsedDate( new Date("OCTOBER/4/2019") );
            this.editedItem.endDate = this.getParsedDate(new Date("OCTOBER/4/2022"));
            this.editedItem.daysCompleted = days360( this.getRealDate(  this.editedItem.startDate  ),  this.getRealDate(this.editedItem.curDate ) );
            this.editedItem.daysLeft = days360(  this.getRealDate(this.editedItem.curDate), this.getRealDate(this.editedItem.endDate) );
            this.editedItem.percentComplete = ( (  this.editedItem.daysCompleted / (  this.editedItem.daysLeft +   this.editedItem.daysCompleted)) * 100  ).toFixed(2);
            this.computeRemaining();
        },
    },
    created() {
        this.initialize();
        this.init();
    }
};
</script>
<style scoped>
.tablex thead th {
    vertical-align: middle;
    border-bottom: 2px solid #dee2e6;
}
</style>
