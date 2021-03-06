<template>
    <v-app>
        <h3 class="subheading grey--text">Finance Tracker</h3>
        <br />
        <v-card>
            <v-data-table :headers="headers" :items="financeList"
                :search="filters.filter_items[filters.filter_items_active].value" :loading="loadFinanceTracker"
                :custom-filter="filterItems" class="elevation-1">
                <template v-slot:top>
                    <v-toolbar flat>
                        <v-spacer></v-spacer>
                        <v-dialog v-model="dialog" max-width="500px">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn color="lightgray" class="mb-2" v-bind="attrs" v-on="on"
                                    v-show="crud_guard.create">
                                    New
                                    <v-icon color="green">mdi-plus-thick</v-icon>
                                </v-btn>
                            </template>
                            <v-card>
                                <v-card-title class="text-h5 font-weight-regular blue-grey darken-3 white--text">
                                    <span class="text-h5" v-if="!detailsReadonly">{{ formTitle}}</span>
                                    <span class="text-h5" v-else>Finance Tracker Details</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-container dense>
                                        
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-combobox :readonly="editedIndex != -1" :rules="[rules.required]"
                                                    v-model="selected_finance_name" :items="responsibleOrganization"
                                                    :search-input.sync="search" hide-selected label="Name"
                                                    hint="Hit backspace to delete selected Name" multiple
                                                    persistent-hint small-chips>
                                                    <template v-slot:no-data>
                                                        <v-list-item>
                                                            <v-list-item-content>
                                                                <v-list-item-title>
                                                                    No results matching "
																	<strong>{{ search }}</strong>
																	". Press <kbd>enter</kbd> 
																	to create a new one
                                                                </v-list-item-title>
                                                            </v-list-item-content>
                                                        </v-list-item>
                                                    </template>
                                                </v-combobox>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field :readonly="detailsReadonly" :rules="[rules.number]"
                                                    ref="refBudget" v-on:keyup="computeBurnRate"
                                                    v-model="editedItem.finance_budget" label="Budget" dense>
                                                </v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field :readonly="detailsReadonly" :rules="[rules.number]"
                                                    v-model="editedItem.finance_tranche1" label="1st Tranche"
                                                    v-on:keyup="computeBurnRate" @input="tranch_date(1)" dense>
                                                </v-text-field>
                                                <p class="text-lowercase mb-5">
                                                    {{ editedItem.finance_tranche1_date }}
                                                </p>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field v-if="editedItem.finance_tranche1 != 0.0"
                                                    v-on:keyup="computeBurnRate" :readonly="detailsReadonly"
                                                    :rules="[rules.number]" v-model="editedItem.finance_tranche2"
                                                    @input="tranch_date(2)" label="2nd Tranche" dense></v-text-field>
                                                <v-text-field v-else disabled :readonly="detailsReadonly"
                                                    :rules="[rules.number]" v-model="editedItem.finance_tranche2"
                                                    @input="tranch_date(2)" label="2nd Tranche" dense></v-text-field>
                                                <p class="text-lowercase mb-5">
                                                    {{ editedItem.finance_tranche2_date }}
                                                </p>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field v-if="editedItem.finance_tranche2 != 0.0"
                                                    v-on:keyup="computeBurnRate" :readonly="detailsReadonly"
                                                    :rules="[rules.number]" v-model="editedItem.finance_tranche3"
                                                    label="3rd Tranche" @input="tranch_date(3)" dense></v-text-field>
                                                <v-text-field v-else disabled :readonly="detailsReadonly"
                                                    :rules="[rules.number]" v-model="editedItem.finance_tranche3"
                                                    label="3rd Tranche" @input="tranch_date(3)" dense></v-text-field>
                                                <p class="text-lowercase mb-5">
                                                    {{ editedItem.finance_tranche3_date }}
                                                </p>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field v-if="editedItem.finance_tranche3 != 0.0"
                                                    v-on:keyup="computeBurnRate" :readonly="detailsReadonly"
                                                    :rules="[rules.number]" v-model="editedItem.finance_tranche4"
                                                    @input="tranch_date(4)" label="4th Tranche" dense></v-text-field>
                                                <v-text-field v-else disabled :readonly="detailsReadonly"
                                                    :rules="[rules.number]" v-model="editedItem.finance_tranche4"
                                                    label="4th Tranche" dense @input="tranch_date(4)"></v-text-field>
                                                <p class="text-lowercase mb-5">
                                                    {{ editedItem.finance_tranche4_date }}
                                                </p>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">

                                                <v-text-field v-if="editedItem.finance_tranche3 != 0.0"
                                                    v-on:keyup="computeBurnRate" :readonly="detailsReadonly"
                                                    :rules="[rules.number]" v-model="editedItem.finance_retention"
                                                    label="Retention" dense></v-text-field>
                                                <v-text-field v-else disabled :readonly="detailsReadonly"
                                                    :rules="[rules.number]" v-model="editedItem.finance_retention"
                                                    label="Retention" dense ></v-text-field>

                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0" v-if="detailsReadonly">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field v-model="editedItem.finance_total" label="Total" dense
                                                    filled disabled></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field :readonly="detailsReadonly" :rules="[rules.number]"
                                                    v-model="editedItem.finance_actuals" label="Actuals" dense>
                                                </v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0" v-if="detailsReadonly">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field v-model="editedItem.finance_variance" label="Variance"
                                                    dense ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0" v-if="detailsReadonly">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field v-model="editedItem.finance_burn_rate"
                                                    label="Burn Rate (Total)" dense filled disabled></v-text-field>
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                </v-card-text>
                                <v-card-actions class=" blue-grey darken-3 white--text" v-if="!detailsReadonly">
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue lighten-5" text @click="close" dense>
                                        Cancel
                                    </v-btn>
                                    <v-btn color="blue lighten-5" text @click="save" dense :loading="btnLoader">
                                        Save
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        <v-dialog v-model="dialogDelete" max-width="500px">
                            <v-card color="blue-grey darken-3">
                                <v-alert text color="red lighten-3" prominent type="error" icon="mdi-alert">Are you sure
                                    you want to delete this item?</v-alert>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue lighten-5" text @click="closeDelete">No</v-btn>
                                    <v-btn color="blue lighten-5" text @click="deleteItemConfirm" :loading="btnLoader">
                                        Yes</v-btn>
                                    <v-spacer></v-spacer>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        &nbsp;&nbsp;
                        <v-btn color="lightgray" class="mb-2" :loading="btnLoader" @click="exportExcel('FinanceTracker', '')" v-show="crud_guard.export" >
                            Export
                            <v-icon color="green">mdi-microsoft-excel</v-icon>
                        </v-btn>
                    </v-toolbar>
                    <v-row no-gutters style="flex-wrap: nowrap" class="my-3">
                        <v-col cols="6" class="flex-grow-0 flex-shrink-0">
                            <v-text-field v-model="filters.filter_items['finance_name'].value"
                                :label="filters.filter_items['finance_name'].text"
                                @input="changeFilterActiveValue('finance_name')" append-icon="mdi-magnify" outlined
                                hide-details></v-text-field>
                        </v-col>
                    </v-row>
                </template>
                <template v-slot:item.finance_budget="{ item }">
                    {{ formatAsCurrency(item.finance_budget, 2) }}
                </template>
                <template v-slot:item.finance_actuals="{ item }">
                    {{ formatAsCurrency(item.finance_actuals, 2) }}
                </template>
                <template v-slot:item.finance_variance="{ item }">
                    {{ formatAsCurrency(item.finance_variance, 2) }}
                </template>
                <template v-slot:item.finance_burn_rate="{ item }">
                    {{ formatAsCurrency(item.finance_burn_rate, 2) }}
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-icon v-show="crud_guard.view" small class="mr-2" @click="detailsItem(item)" color="blue"
                        data-toggle="tooltip" data-placement="top" title="Finance Tracker Details">
                        mdi-information-outline
                    </v-icon>
                    <v-icon v-show="crud_guard.update" small class="mr-2" @click="editItem(item)" color="blue darken-2"
                        data-toggle="tooltip" data-placement="top" title="Edit Finance Tracker">
                        mdi-pencil
                    </v-icon>
                    <v-icon small @click="deleteItem(item)" color="red" data-toggle="tooltip" data-placement="top"
                        title="Delete This Item" v-show="crud_guard.delete">
                        mdi-delete
                    </v-icon>
                </template>
            </v-data-table>
        </v-card>
    </v-app>
</template>
<script>
    export default {
        data: (vm) => ({
            btnLoader: false,
            dialog: false,
            dialogDelete: false,
            loadFinanceTracker: false,
            detailsReadonly: false,
            modelAssessmentDate: false,
            cso_name_items: [],
            selected_finance_name: [],
            search: null,
            status_list: [],
            searchBy: "",
            crud_guard: {
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
            responsibleOrganization: [],
            filters: {
                filter_items_active: "finance_name",
                filter_items: {
                    finance_name: {
                        value: "",
                        text: "Name",
                        data_value: "finance_name",
                    },
                }
            },
            headers: [{
                    text: "Name",
                    align: "start",
                    sortable: false,
                    value: "finance_name",
                    width: "12%",
                },
                {
                    text: "Budget",
                    value: "finance_budget",
                    width: "8%",
                    sortable: false,
                    align: "end",
                },
                {
                    text: "Actuals",
                    value: "finance_actuals",
                    width: "8%",
                    sortable: false,
                    align: "end",
                },
                {
                    text: "Variance",
                    value: "finance_variance",
                    width: "8%",
                    sortable: false,
                    align: "end",
                },
                {
                    text: "Burn Rate",
                    //value: "finance_burn_rate", no % sign
                    value: "finance_burn_rate_perc",
                    width: "8%",
                    sortable: false,
                    align: "end",
                },
                {
                    text: "Actions",
                    value: "actions",
                    width: "8%",
                    sortable: false
                },
            ],
            financeList: [],
            editedIndex: -1,
            editedItem: {
                finance_name: "",
                finance_budget: "",
                finance_tranche1: "",
                finance_tranche2: "",
                finance_tranche3: "",
                finance_tranche4: "",
                finance_retention: "",
                finance_tranche1_date: "",
                finance_tranche2_date: "",
                finance_tranche3_date: "",
                finance_tranche4_date: "",
                finance_total: "",
                finance_actuals: "",
                finance_variance: "",
                finance_burn_rate: "",
            },
            defaultItem: {
                finance_name: "",
                finance_budget: "",
                finance_tranche1: "",
                finance_tranche2: "",
                finance_tranche3: "",
                finance_tranche4: "",
                finance_retention: "",
                finance_tranche1_date: "",
                finance_tranche2_date: "",
                finance_tranche3_date: "",
                finance_tranche4_date: "",
                finance_total: "",
                finance_actuals: "",
                finance_variance: "",
                finance_burn_rate: "",
            },
            delete_finance: "",
            rules: {
                required: (v) => !!v || "This field is required",
                number: (v) => {
                    if (!v.trim()) return true;
                    if (!isNaN(parseFloat(v)) && v >= 0) return true;
                    return "The value entered was not valid.";
                },
            },
        }),

        computed: {
            formTitle() {
                return this.editedIndex === -1 ?
                    "New Finance Tracker" :
                    "Edit Finance Tracker";
            },
        },

        watch: {
            dialog(val) {
                val || this.close();
            },
            dialogDelete(val) {
                val || this.closeDelete();
            },
            selected_finance_name(val) {
                if (val.length > 1) {
                    this.$nextTick(() => this.selected_finance_name.pop());
                    this.$noty.error("You Can Only Use 1 Name");
                }
            },
        },

        created() {
            this.initialize();
        },

        methods: {
            initialize() {
                document.title = "SCP: CSO² Project | Finance Tracker";
                axios.get("/user-roles-permission").then((response) => {
                    const moduleName = "FinanceTracker";
                    const data = response.data;
                    for (const key in data) {
                        if (data[key].name == moduleName) {
                            const crud_guard = data[key].crud_guard[0];
                            if (crud_guard.view == 0) this.$router.push("dashboard");
                            else this.crud_guard = crud_guard;
                            break;
                        }
                    }
                });

                this.loadFinanceTracker = true;
                axios.get("/finance-tracker").then((response) => {
                    this.financeList = response.data;
                    // Add new property for table that show burn rate with % sign
                    // as requested during turn over
                    this.financeList.forEach((finance, idx) => {
                        let newFinance = {
                            ...finance,
                            finance_burn_rate_perc : `${finance.finance_burn_rate}%`
                        }

                        this.financeList[idx] = newFinance
                    })
                    this.loadFinanceTracker = false;
                });
                axios.get("/get-lead-organization").then((res) => {
                    this.responsibleOrganization = res.data;
                });
            },
            tranch_date(tranch_num) {
                const t = new Date();
                const dd = ("0" + t.getDate()).slice(-2);
                const mm = ("0" + (t.getMonth() + 1)).slice(-2);
                const yyyy = t.getFullYear();

                const time = `${mm}/${dd}/${yyyy}`;
                this.editedItem[`finance_tranche${tranch_num}_date`] = time;
            },
            filterItems(items, search, filter) {
                return new this.$MultiFilters(
                    items,
                    search,
                    filter,
                    this.filters.filter_items
                ).custom_filter();
            },
            changeFilterActiveValue(key) {
                const filter = this.filters.filter_items;
                const active_key = this.filters.filter_items_active;
                const active_value = filter[active_key].value;
                this.filters.filter_items_active =
                    this.$MultiFilters.changeFilterActiveValue(
                        key,
                        filter,
                        active_key,
                        active_value
                    );
            },
            detailsItem(item) {
                this.detailsReadonly = true;
                this.editedIndex = this.financeList.indexOf(item);
                this.editedItem = Object.assign({}, item);
                this.selected_finance_name = [{
                    text: item.finance_name,
                    value: item.finance_name
                }, ];
                this.dialog = true;
                this.computeBurnRate();
            },
            editItem(item) {
                this.editedIndex = this.financeList.indexOf(item);
                this.editedItem = Object.assign({}, item);
                this.selected_finance_name = [{
                    text: item.finance_name,
                    value: item.finance_name
                }, ];
                this.dialog = true;
                this.computeBurnRate();
            },
            deleteItem(item) {
                this.delete_finance = item.finance_id;
                this.editedIndex = this.financeList.indexOf(item);
                this.editedItem = Object.assign({}, item);
                this.dialogDelete = true;
                this.computeBurnRate();
            },

            deleteItemConfirm() {
                this.btnLoader = true;
                this.financeList.splice(this.editedIndex, 1);
                axios
                    .post("/delete-finance-tracker", {
                        delete_id: this.delete_finance,
                    })
                    .then((response) => {
                        if (response.data.success) {
                            this.initialize();
                            this.$noty.success("Successfully deleted.");
                            this.closeDelete();
                        }
                    });
            },

            close() {
                this.dialog = false;
                this.detailsReadonly = false;
                this.btnLoader = false;
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem);
                    this.editedIndex = -1;
                });
                this.selected_finance_name = [];
            },

            closeDelete() {
                this.btnLoader = false;
                this.dialogDelete = false;
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem);
                    this.editedIndex = -1;
                });
            },

            save() {
                this.btnLoader = true;
                let validate = true;

                if (this.selected_finance_name.length === 0) {
                    this.validate = false;
                    this.$noty.error("Name is Empty!");
                } else {
                    if (
                        Object.prototype.toString.call(this.selected_finance_name[0]) ===
                        "[object Object]"
                    ) {
                        this.editedItem.finance_name = this.selected_finance_name[0].value;
                        //////console.log("SET AS STRING BUT ITS OBJ ", this.editedItem)
                    } else {
                        this.editedItem.finance_name = this.selected_finance_name[0];
                        //////console.log("SET AS STRING BUT ITS ARR ", this.editedItem)
                    }
                }

                if (validate) {
                    axios
                        .post("/save-finance-tracker", {
                            data: JSON.stringify(this.editedItem),
                            form_mode: this.editedIndex,
                        })
                        .then((response) => {
                            if (response.data.success) {
                                this.initialize();
                                if (this.editedIndex < 0) {
                                    this.$noty.success("Successfully Added.");
                                } else {
                                    this.$noty.success("Successfully Updated.");
                                }
                                this.close();
                            } else {
                                this.btnLoader = false;
                                this.close();
                            }
                            this.btnLoader = false;
                        });
                } else {
                    this.btnLoader = false;
                }
            },
            getBurn(tran, budg) {
                return ((tran / budg) * 100).toFixed(2);
            },
            computeBurnRate: function () {
            },
            formatAsCurrency: function (amt, dec) {
                amt = parseFloat(amt);
                if (amt) {
                    dec = dec || 0;
                    if (amt < 0) {
                        amt = amt * -1;
                        amt = amt.toFixed(dec);
                        var _amt = amt.toString().split(".", 2);
                        return (
                            "(" +
                            _amt[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") +
                            "." +
                            _amt[1] +
                            ")"
                        );
                    } else {
                        amt = amt.toFixed(dec);
                        var _amt = amt.toString().split(".", 2);
                        return (
                            "" + _amt[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "." + _amt[1]
                        );
                    }
                } else {
                    amt = 0;
                    amt = amt.toFixed(dec);
                    var _amt = amt.toString().split(".", 2);
                    return (
                        "" + _amt[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".") + "." + _amt[1]
                    );
                }
            },

            exportExcel: function (tableName, value) {
                this.btnLoader = true;
                let filename = tableName + ".xlsx";
                var formData = new FormData();
                formData.append("tableName", tableName);
                axios
                    .post("/export-excel", formData, {
                        responseType: "blob"
                    })
                    .then((response) => {
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement("a");
                        link.href = url;
                        link.setAttribute("download", filename);
                        document.body.appendChild(link);
                        link.click();
                        this.btnLoader = false;
                    });
            },
        },
    };

</script>
