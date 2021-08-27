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
                                <div class="overline text-right">
                                    SOF number:
                                </div>
                                <v-list-item-title class="headline  text-right"
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
                                    Start Date :<strong> 2/1/2021 </strong>
                                </div>
                                <div class="overline text-left">
                                    Current Date : <strong> {{parsedDate}} </strong>
                                </div>
                                <div class="overline text-left">
                                    Days Completed :<strong> 144 </strong>
                                </div>
                                <div class="overline text-left">
                                    Days Left : <strong> 936 </strong>
                                </div>
                                <div class="overline text-left">
                                    End Date: <strong> 1/31/2024 </strong>
                                </div>
                                <div class="overline text-left">
                                    Percent Complete :
                                    <strong> 1/31/2024 </strong>
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
                                    Remaining: <strong> $ 1,964,999 </strong>
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
<<<<<<< HEAD
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
=======
                    </v-list-item>
                </v-card>
                <v-card class="ma-1 mt-6">
                    <v-list-item  >
                        <v-list-item-content>
                            <div class="overline text-left">Start Date :<strong>  2/1/2021 </strong></div>
                            <div class="overline text-left">Current Date :  <strong> 6/25/2021 </strong> </div>
                            <div class="overline text-left">Days Completed :<strong> 144  </strong> </div>
                            <div class="overline text-left">Days Left : <strong> 936 </strong> </div>
                            <div class="overline text-left">End Date: <strong> 1/31/2024 </strong> </div>
                            <div class="overline text-left">Percent Complete : <strong> 1/31/2024 </strong> </div>
                        </v-list-item-content>
                    </v-list-item>
                </v-card>
                <v-card class="ma-1 mt-6">
                    <v-list-item  >
                        <v-list-item-content>
                            <div class="overline text-left"> Total Budget (USD) : <strong> $ 1,999,998.57 </strong> </div>
                            <div class="overline text-left"> Spent to date:  <strong> $ 35,000 </strong> </div>
                            <div class="overline text-left"> Remaining:  <strong> $ 1,964,999 </strong> </div>
                            <div class="overline text-left"> Burn rate:  <strong> 1.75% </strong> </div>
                            <div class="overline text-left"> Next donor report due to Awards:  <strong> 'Quarter 3 -- July 31, 2021 (covers Apr 1 to June 30, 2021)  </strong> </div>
                        </v-list-item-content>
                    </v-list-item>
                </v-card>
            </v-col >
            <v-col cols="12" sm="6" md="6" ma='1'>
                 <v-card class="ma-1 mt-6">
                    <v-list-item  >
                        <v-list-item-content>
                            <v-list-item-title class="headline  text-left ma-1 mb-5" >Project Summary:  </v-list-item-title>
                            <p class="overline"> The project will have the following learning priorities: Systems-and-Networks-Based Analytical Approach to better understand the complex environments in which CSOs and CSO networks operate and thereby help inform the design for Strengthening Local Networks to be fit for purpose in the context of their role in the network. More importantly, this project will provide valuable learnings on Supporting Strategic Transitions since this activity will engage CSOs and CSO networks to collaboratively design plans and interventions that would enable them to become strong and sustainable LROs.</p>
                                
                        </v-list-item-content>
                    </v-list-item>
                </v-card>
                <v-card class="ma-1 mt-6">
                    <v-list-item>
                        <v-list-item-content>
                            <v-card-text >
                                <v-container dense>
                                    <div class="overline text-left"> Location : <strong> Quezon City </strong> </div>
                                    <div class="overline text-left"> Awards source:  <strong> USAID </strong> </div>
                                    <div class="overline text-left"> Member:   <strong> Philippines Member Domestic Program</strong> </div>
                                </v-container>
                            </v-card-text>
                        </v-list-item-content>
                    </v-list-item>
                </v-card>
            </v-col>
        </v-row>
        <v-card class="ma-1">
            <v-list-item  >
                <v-list-item-content>
                    <v-card-text >
                        <v-container dense>
                            <div class="overline text-left">Actions or support needed (include person responsible):  <strong> (PDQ TA) </strong></div>
                            <v-textarea auto-grow rows="3"  label="Description *" dense > </v-textarea>
                        </v-container>
                    </v-card-text>
                </v-list-item-content>
            </v-list-item>
        </v-card>
     </v-container>
>>>>>>> 19e4fad847a5ff3016f7f7f9af1a036bdbde6b46
    </v-app>
</template>
<script>
import VueNumeric from "vue-numeric";

export default {
    components: {
        VueNumeric
    },
    data() {
        return {
            totalBudget: 1999998.57,
            spentToDate: 0,
            burnRate: "-.-%",
            startDate: new Date('2/01/2021') ,
            rawDate : new Date(),
            parsedDate : '-/-/-'
        };
    },
    methods: {
        setBurnRate() {
            if(!isNaN(Number.parseFloat(this.spentToDate))){
                this.burnRate = ((Number.parseFloat(this.spentToDate) / this.totalBudget)*100).toFixed(2)+'%'
                return;
            }
            this.burnRate = "-.-%"
        },
        setParsedDate(){
            this.parsedDate =`${this.rawDate.toLocaleString('en-us', { month: 'long' })}/${this.rawDate.getDate()}/${this.rawDate.getFullYear()}`
        }
    },
    created(){
        this.setBurnRate();
        this.setParsedDate();
    }
};
</script>
<style scoped>
.tablex thead th {
    vertical-align: middle;
    border-bottom: 2px solid #dee2e6;
}
</style>
