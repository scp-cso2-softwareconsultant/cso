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
                                    Start Date :<strong> {{startDate}} </strong>
                                </div>
                                <div class="overline text-left">
                                    Current Date : <strong> {{curDate}} </strong>
                                </div>
                                <div class="overline text-left">
                                    Days Completed :<strong> {{daysCompleted}} </strong>
                                </div>
                                <div class="overline text-left">
                                    Days Left : <strong> {{daysLeft}} </strong>
                                </div>
                                <div class="overline text-left">
                                    End Date: <strong> {{endDate}} </strong>
                                </div>
                                <div class="overline text-left">
                                    Percent Complete :
                                    <strong> {{percentComplete}} </strong>
                                </div>
                            </v-list-item-content>
                        </v-list-item>
                    </v-card>
                    <v-card class="ma-1 mt-6">
                        <v-list-item>
                            <v-list-item-content>
                                <div class="overline text-left">
                                    Total Budget (USD) :
                                    <strong> <vue-numeric currency="$" separator="," read-only v-model="totalBudget"></vue-numeric></strong>
                                </div>
                                <div class="overline text-left">
                                    <v-text-field
                                        label="Spent To Date : "
                                        v-model="spentToDate"
                                        v-on:keyup="setBurnRate"
                                    ></v-text-field>
                                </div>
                                <div class="overline text-left">
                                    Remaining: <strong> <vue-numeric currency="$" separator="," read-only v-model="remaining"></vue-numeric> </strong>
                                </div>
                                <div class="overline text-left">
                                    Burn rate: <strong>{{ burnRate }}</strong>
                                </div>
                                <div class="overline text-left">
                                    <strong
                                        ><v-text-field
                                            type="email"
                                            label="Next donor report due to Awards : "
                                            
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
                                Estimated progress to date
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
                                <v-textarea
                                    auto-grow
                                    rows="2"
                                    label=""
                                    dense
                                ></v-textarea>
                            </td>
                            <td>
                                <v-textarea
                                    auto-grow
                                    rows="2"
                                    label=""
                                    dense
                                ></v-textarea>
                            </td>
                            <td>
                                <v-textarea
                                    auto-grow
                                    rows="2"
                                    label=""
                                    dense
                                ></v-textarea>
                            </td>
                            <td class="text-center">
                                <v-textarea
                                    class="text-center"
                                    auto-grow
                                    rows="2"
                                    label=""
                                    value="30%"
                                    dense
                                ></v-textarea>
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
                                <v-textarea
                                    auto-grow
                                    rows="2"
                                    label=""
                                    dense
                                ></v-textarea>
                            </td>
                            <td>
                                <v-textarea
                                    auto-grow
                                    rows="2"
                                    label=""
                                    dense
                                ></v-textarea>
                            </td>
                            <td>
                                <v-textarea
                                    auto-grow
                                    rows="2"
                                    label=""
                                    dense
                                ></v-textarea>
                            </td>
                            <td class="text-center">
                                <v-textarea
                                    class="text-center"
                                    auto-grow
                                    rows="2"
                                    label=""
                                    value="0%"
                                    dense
                                ></v-textarea>
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
                                <v-textarea
                                    auto-grow
                                    rows="2"
                                    label=""
                                    dense
                                ></v-textarea>
                            </td>
                            <td>
                                <v-textarea
                                    auto-grow
                                    rows="2"
                                    label=""
                                    dense
                                ></v-textarea>
                            </td>
                            <td>
                                <v-textarea
                                    auto-grow
                                    rows="2"
                                    label=""
                                    dense
                                ></v-textarea>
                            </td>
                            <td>
                                <v-textarea
                                    class="text-center"
                                    auto-grow
                                    rows="2"
                                    label=""
                                    value="0%"
                                    dense
                                ></v-textarea>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="p-4">Objective 4:</th>
                            <td class="p-3"></td>
                            <td>
                                <v-textarea
                                    auto-grow
                                    rows="2"
                                    label=""
                                    dense
                                ></v-textarea>
                            </td>
                            <td>
                                <v-textarea
                                    auto-grow
                                    rows="2"
                                    label=""
                                    dense
                                ></v-textarea>
                            </td>
                            <td>
                                <v-textarea
                                    auto-grow
                                    rows="2"
                                    label=""
                                    dense
                                ></v-textarea>
                            </td>
                            <td class="text-center">
                                <v-textarea
                                    auto-grow
                                    rows="2"
                                    label=""
                                    dense
                                ></v-textarea>
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
                                <v-textarea
                                    auto-grow
                                    rows="3"
                                    label="Description *"
                                    dense
                                >
                                </v-textarea>
                            </v-container>
                        </v-card-text>
                    </v-list-item-content>
                </v-list-item>
            </v-card>
        </v-container>
    </v-app>
</template>
<script>
import VueNumeric from "vue-numeric";
const days360 = require('days360');

export default {
    components: {
        VueNumeric
    },
    data() {
        return {
            totalBudget: 1999998.57,
            spentToDate: 0,
            rawDate : {
                startDate : "2/1/2021",
                endDate : "1/31/2024"
            },
            burnRate: "-.-%",
            startDate: '-/-/-',
            curDate : '-/-/-',
            endDate : '-/-/-',
            daysCompleted : 0,
            daysLeft : 0,
            percentComplete : 0,
            remaing : 0
        };
    },
    methods: {
        setBurnRate() {
            console.log(this.startDate)
            if(!isNaN(Number.parseFloat(this.spentToDate))){
                this.burnRate = ((Number.parseFloat(this.spentToDate) / this.totalBudget)*100).toFixed(2)+'%'
                this.computeRemaining()
                return;
            }
            this.burnRate = "-.-%"
        },
        getParsedDate(date){
            return `${date.toLocaleString('en-us', { month: 'long' })}/${date.getDate()}/${date.getFullYear()}`
        },
        getRealDate(date){
            return new Date(date);
        },
        computeRemaining(){
            this.remaining = this.totalBudget - this.spentToDate
        }
        ,
        init(){
            this.setBurnRate();
            this.curDate = this.getParsedDate(new Date());
            this.endDate = this.getParsedDate(new Date(this.rawDate.endDate))
            this.startDate = this.getParsedDate(new Date(this.rawDate.startDate))
            this.daysCompleted = days360(this.getRealDate(this.rawDate.startDate), new Date())
            this.daysLeft = days360(new Date(),this.getRealDate(this.rawDate.endDate))
            this.percentComplete = `${(this.daysCompleted/(this.daysLeft + this.daysCompleted) * 100).toFixed(2)} %`
            this.computeRemaining()
        }
    },
    created(){
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
