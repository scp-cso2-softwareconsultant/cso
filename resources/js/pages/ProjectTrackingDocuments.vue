<template>
    <v-app>
        <h3 class="subheading grey--text">Project Tracking Document</h3>
        <div class="overline text-left grey--text">
            CAPACITATING STRATEGIC ORGANIZATIONS TO STRENGTHEN THE CIVIL SOCIETY
            ORGANIZATION SECTOR (CSO2)
        </div>
        <v-spacer> </v-spacer>
        <v-container dense>
            <v-row>
                <v-col cols="12" sm="6" md="6">
                    <v-card class="ma-1 border-top">
                        <v-list-item>
                            <v-list-item-content>
                                <div class="overline text-left">
                                    SOF number:
                                </div>
                                <v-list-item-title class="headline  text-left"
                                    >60900090</v-list-item-title
                                >
                            </v-list-item-content>
                        </v-list-item>
                    </v-card>
                    <v-card class="ma-1 mt-6">
                        <v-list-item>
                            <v-list-item-content>
                                <div class="overline text-left">
                                    Project Holder :
                                    <strong> Magdalena Lopez </strong>
                                </div>
                                <div class="overline text-left">
                                    Supervisor: <strong> </strong>
                                </div>
                                <div class="overline text-left">
                                    Sector/Thematic Area: <strong> </strong>
                                </div>
                                <div class="overline text-left">
                                    Program Office:
                                    <strong>
                                        CSO2 Program/Quezon City Program Office
                                    </strong>
                                </div>
                            </v-list-item-content>
                        </v-list-item>
                    </v-card>
                    <v-card class="ma-1 mt-6">
                        <v-list-item>
                            <v-list-item-content>
                                <div class="overline text-left">
                                    Start Date :<strong>
                                        {{ startDate }}
                                    </strong>
                                </div>
                                <div class="overline text-left">
                                    Current Date :
                                    <strong> {{ curDate }} </strong>
                                </div>
                                <div class="overline text-left">
                                    Days Completed :<strong>
                                        {{ daysCompleted }}
                                    </strong>
                                </div>
                                <div class="overline text-left">
                                    Days Left :
                                    <strong> {{ daysLeft }} </strong>
                                </div>
                                <div class="overline text-left">
                                    End Date: <strong> {{ endDate }} </strong>
                                </div>
                                <div class="overline text-left">
                                    Percent Complete :
                                    <strong> {{ percentComplete }} </strong>
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
                                        <vue-numeric currency="$" separator="," read-only v-model="totalBudget" ></vue-numeric
                                    ></strong>
                                </div>
                                <div class="overline text-left">
                                    <v-text-field
                                        label="Spent To Date : "
                                        v-model="editedItem.spent_to_date"
                                        v-on:keyup="setBurnRate"
                                    ></v-text-field>
                                </div>
                                <div class="overline text-left">
                                    Remaining:
                                    <strong>
                                        <vue-numeric
                                            currency="$"
                                            separator=","
                                            read-only
                                            v-model="remaining"
                                        ></vue-numeric>
                                    </strong>
                                </div>
                                <div class="overline text-left">
                                    Burn rate: <strong>{{ burnRate }}</strong>
                                </div>
                                <div class="overline text-left">
                                    <strong
                                        ><v-text-field
                                            type="email"
                                            label="Next donor report due to Awards : "
                                            v-model="editedItem.donor_report"
                                        ></v-text-field
                                    ></strong>
                                </div>
                            </v-list-item-content>
                        </v-list-item>
                    </v-card>
                </v-col>
                <v-col cols="12" sm="6" md="6" ma="1">
                    <v-card class="ma-1 mt-6 p-6">
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title
                                    class="headline  text-left ma-1 mb-5"
                                    >Project Summary:
                                </v-list-item-title>
                                <p class="overline text-justify">
                                    The project will have the following learning
                                    priorities: Systems-and-Networks-Based
                                    Analytical Approach to better understand the
                                    complex environments in which CSOs and CSO
                                    networks operate and thereby help inform the
                                    design for Strengthening Local Networks to
                                    be fit for purpose in the context of their
                                    role in the network. More importantly, this
                                    project will provide valuable learnings on
                                    Supporting Strategic Transitions since this
                                    activity will engage CSOs and CSO networks
                                    to collaboratively design plans and
                                    interventions that would enable them to
                                    become strong and sustainable LROs.
                                </p>
                            </v-list-item-content>
                        </v-list-item>
                    </v-card>
                    <v-card class="ma-1 mt-6">
                        <v-list-item>
                            <v-list-item-content>
                                <v-card-text>
                                    <v-container dense>
                                        <div class="overline text-left">
                                            Location :
                                            <strong> Quezon City </strong>
                                        </div>
                                        <div class="overline text-left">
                                            Awards source:
                                            <strong> USAID </strong>
                                        </div>
                                        <div class="overline text-left">
                                            Member:
                                            <strong>
                                                Philippines Member Domestic
                                                Program</strong
                                            >
                                        </div>
                                    </v-container>
                                </v-card-text>
                            </v-list-item-content>
                        </v-list-item>
                    </v-card>
                </v-col>
            </v-row>
            <v-card class="my-6 ">
                <table class="table tablex table-striped">
                    <thead>
                        <tr
                            class="text-center shadow-sm p-3 mb-5 bg-white rounded"
                        >
                            <th scope="col" style="width: 15%;"></th>
                            <th scope="col" class="p-4">
                                (Include specfiic indicators where possible)
                            </th>
                            <th scope="col" class="p-4">
                                Implementation versus target progress
                            </th>
                            <th scope="col" class="p-4">
                                Recent issues or challenges (logs, Finance,
                                Admin, Program and awards, partnership,
                                security)
                            </th>
                            <th scope="col" class="p-4">Next month planning</th>
                            <th scope="col" class="p-4">
                                Estimated progress to date in (%)
                            </th>
                        </tr>
                    </thead>
                    <v-spacer class="mt-5"></v-spacer>
                    <tbody>
                        <tr>
                            <th scope="row" class="p-4">Objective 1:</th>
                            <td class="p-3">
                                1. LROs with enhanced organizational capacity to
                                support CSOs in their network.
                            </td>
                            <td>
                                <v-textarea auto-grow rows="2" label=""  v-model="editedItem.objective[0].Implementation_vs_target"> </v-textarea>
                            </td>
                            <td>
                                <v-textarea auto-grow rows="2" label="" dense v-model="editedItem.objective[0].challanges"></v-textarea>
                            </td>
                            <td>
                                <v-textarea auto-grow rows="2" label="" dense v-model="editedItem.objective[0].next_month_planning"></v-textarea>
                            </td>
                            <td class="text-center">
                                <v-textarea class="text-center" auto-grow rows="2" label="" v-model="editedItem.objective[0].estimated_progress" type="number" @keypress="onlyNumber" dense ></v-textarea>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="p-4">Objective 2:</th>
                            <td class="p-3">
                                2. LROs demonstrate good financial housekeeping
                                towards their constituents to include other
                                CSOs/CSO networks and donors
                            </td>
                            <td>
                                <v-textarea auto-grow rows="2" label="" dense v-model="editedItem.objective[1].Implementation_vs_target" ></v-textarea>
                            </td>
                            <td>
                                <v-textarea auto-grow rows="2" label="" dense v-model="editedItem.objective[1].challanges"  ></v-textarea>
                            </td>
                            <td>
                                <v-textarea auto-grow rows="2" label="" dense v-model="editedItem.objective[1].next_month_planning"></v-textarea>
                            </td>
                            <td class="text-center">
                                <v-textarea class="text-center" auto-grow rows="2" label=""  v-model="editedItem.objective[1].estimated_progress" dense type="number"  @keypress="onlyNumber" ></v-textarea>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="p-4">Objective 3:</th>
                            <td class="p-3">
                                3. LROs with the capacity to ensure financial
                                sustainability to function as support to CSOs in
                                their network.
                            </td>
                            <td>
                                <v-textarea auto-grow rows="2" label="" dense v-model="editedItem.objective[2].Implementation_vs_target" ></v-textarea>
                            </td>
                            <td>
                                <v-textarea auto-grow rows="2" label="" dense v-model="editedItem.objective[2].challanges"></v-textarea>
                            </td>
                            <td>
                                <v-textarea auto-grow  rows="2" label="" dense v-model="editedItem.objective[2].next_month_planning"></v-textarea>
                            </td>
                            <td>
                                <v-textarea class="text-center" auto-grow rows="2" label=""  v-model="editedItem.objective[2].estimated_progress" type="number" @keypress="onlyNumber" dense></v-textarea>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="p-4">Objective 4:</th>
                            <td class="p-3">
                                <v-textarea auto-grow rows="2" label="" dense v-model="editedItem.objective[3].indicators"></v-textarea>
                            </td>
                            <td>
                                <v-textarea auto-grow rows="2" label="" v-model="editedItem.objective[3].Implementation_vs_target" append-outer-icon=""dense> </v-textarea>
                            </td>
                            <td>
                                <v-textarea auto-grow rows="2" label="" dense v-model="editedItem.objective[3].challanges"></v-textarea>
                            </td>
                            <td>
                                <v-textarea auto-grow rows="2" label="" dense v-model="editedItem.objective[3].next_month_planning"></v-textarea>
                            </td>
                            <td class="text-center">
                                <v-textarea auto-grow rows="2" label=""  v-model="editedItem.objective[3].estimated_progress" type="number" @keypress="onlyNumber" dense></v-textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </v-card>
            <v-card class="ma-1">
                <v-list-item>
                    <v-list-item-content>
                        <v-card-text>
                            <v-container dense>
                                <div class="overline text-left">
                                    Actions or support needed (include person
                                    responsible): <strong> (PDQ TA) </strong>
                                </div>
                                <v-textarea auto-grow  rows="3" label="Description *" dense v-model="editedItem.actions_or_support">
                                </v-textarea>
                            </v-container>
                        </v-card-text>
                    </v-list-item-content>
                </v-list-item>
            </v-card>
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
        </v-container>
    </v-app>
</template>
<script>
import VueNumeric from "vue-numeric";
const days360 = require("days360");

export default {
    components: {
        VueNumeric
    },
    data() {
        return {
            canBeSaved: false,
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
                donor_report:"",
                spent_to_date:0,
                actions_or_support:"",
                objective:[
                    {
                        Implementation_vs_target:"",
                        Objective:"",
                        challanges:"",
                        estimated_progress:0,
                        indicators:"",
                        next_month_planning:""
                    },
                    {
                        Implementation_vs_target:"",
                        Objective:"",
                        challanges:"",
                        estimated_progress:0,
                        indicators:"",
                        next_month_planning:""
                    },
                    {
                        Implementation_vs_target:"",
                        Objective:"",
                        challanges:"",
                        estimated_progress:0,
                        indicators:"",
                        next_month_planning:""
                    },
                    {
                        Implementation_vs_target:"",
                        Objective:"",
                        challanges:"",
                        estimated_progress:0,
                        indicators:"",
                        next_month_planning:""
                    }
                ],
            },
            totalBudget: 1999998.57,
        
            btnLoader: false,
            rawDate: {
                startDate: "2/1/2021",
                endDate: "1/31/2024"
            },
            burnRate: "-.-%",
            startDate: "-/-/-",
            curDate: "-/-/-",
            endDate: "-/-/-",
            daysCompleted: 0,
            daysLeft: 0,
            percentComplete: 0,
            remaining: 0,
            donor_report:""
        };
    },
    methods: {
        initialize() {
            document.title = "CSO | Project Tracking Document";
            axios.get('/user-roles-permission').then( response => {
                const moduleName = 'ProjectTrackingDocuments';
                const data = response.data; 
                for (const key in  data ){
                    if( data[key].name == moduleName ){
                        const crud_guard = data[key].crud_guard[0];
                        if( crud_guard.view == 0 ) this.$router.push("dashboard");
                        else this.crud_guard =  crud_guard ;
                        break;
                    }
                }
            })
            this.getData();  
        },
      
        onlyNumber ($event) {
            //console.log($event.keyCode); //keyCodes value
            let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
            if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
                $event.preventDefault();
            }
        },    
         save() {
            if(this.canBeSaved && this.crud_guard.update ){
                this.btnLoader = true;
                axios.post("/save-project-tracking-document", { data: JSON.stringify(this.editedItem) }).then(response => {
                    
                    this.btnLoader = false;
                })
                
            }
            // console.log(this.editedItem)
           
        },
        getData(){
            
             axios.get('/get-project-tracking-document').then(response =>{
                const data = response.data[0];
                this.editedItem =  data[0]
                this.editedItem['objective'] = data[1]
                // editedItem.objective.Implementation_vs_target
                this.setBurnRate();
                this.canBeSaved = true;
            })
            
        },
        setBurnRate() {
            // console.log(this.startDate);
            if (!isNaN(Number.parseFloat(this.editedItem.spent_to_date))) {
                this.burnRate =
                    (
                        (Number.parseFloat(this.editedItem.spent_to_date) /
                            this.totalBudget) *
                        100
                    ).toFixed(2) + "%";
                this.computeRemaining();
                return;
            }
            this.burnRate = "-.-%";
        },
        getParsedDate(date) {
            return `${date.toLocaleString("en-us", {
                month: "long"
            })}/${date.getDate()}/${date.getFullYear()}`;
        },
        getRealDate(date) {
            return new Date(date);
        },
        computeRemaining() {
            this.remaining = this.totalBudget - this.editedItem.spent_to_date;
        },
        init() {
            this.setBurnRate();
            this.curDate = this.getParsedDate(new Date());
            this.endDate = this.getParsedDate(new Date(this.rawDate.endDate));
            this.startDate = this.getParsedDate(
                new Date(this.rawDate.startDate)
            );
            this.daysCompleted = days360(
                this.getRealDate(this.rawDate.startDate),
                new Date()
            );
            this.daysLeft = days360(
                new Date(),
                this.getRealDate(this.rawDate.endDate)
            );
            this.percentComplete = `${(
                (this.daysCompleted / (this.daysLeft + this.daysCompleted)) *
                100
            ).toFixed(2)} %`;
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
