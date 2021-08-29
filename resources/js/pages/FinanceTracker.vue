<template>
    <v-app>
        <h3 class="subheading grey--text">Finance Tracker</h3>
        <br />
        <v-card>
            <v-data-table
                :headers="headers"
                :items="financeList"
                :search="searchBy"
                :loading="loadFinanceTracker"
                class="elevation-1"
            >
                <template v-slot:top>
                    <v-toolbar flat>
                        <v-text-field
                            v-model="searchBy"
                            append-icon="mdi-magnify"
                            label="Search"
                            single-line
                            hide-details
                        ></v-text-field>
                        <v-spacer></v-spacer>
                        <v-dialog v-model="dialog" max-width="500px">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    color="lightgray"
                                    class="mb-2"
                                    v-bind="attrs"
                                    v-on="on"
                                >
                                    New
                                    <v-icon color="green"
                                        >mdi-plus-thick</v-icon
                                    >
                                </v-btn>
                            </template>
                            <v-card>
                                <v-card-title>
                                    <span
                                        class="text-h5"
                                        v-if="!detailsReadonly"
                                        >{{ formTitle }}</span
                                    >
                                    <span class="text-h5" v-else
                                        >Finance Tracker Details</span
                                    >
                                </v-card-title>

                                <v-card-text>
                                    <v-container dense>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field
                                                    :readonly="detailsReadonly"
                                                    :rules="[rules.required]"
                                                    v-model="
                                                        editedItem.finance_code
                                                    "
                                                    label="Code *"
                                                    dense
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field
                                                    :readonly="detailsReadonly"
                                                    :rules="[rules.required]"
                                                    v-model="
                                                        editedItem.finance_name
                                                    "
                                                    label="Name *"
                                                    dense
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field
                                                    :readonly="detailsReadonly"
                                                    v-model="
                                                        editedItem.finance_location
                                                    "
                                                    label="Location"
                                                    dense
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field
                                                    :readonly="detailsReadonly"
                                                    v-model="
                                                        editedItem.finance_cost_center
                                                    "
                                                    label="Cost Center"
                                                    dense
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field
                                                    :readonly="detailsReadonly"
                                                    v-model="
                                                        editedItem.finance_project_code
                                                    "
                                                    label="Project Code"
                                                    dense
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field
                                                    :readonly="detailsReadonly"
                                                    v-model="
                                                        editedItem.finance_sof
                                                    "
                                                    label="SOF"
                                                    dense
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field
                                                    :readonly="detailsReadonly"
                                                    v-model="
                                                        editedItem.finance_dea
                                                    "
                                                    label="DEA"
                                                    dense
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field
                                                    :readonly="detailsReadonly"
                                                    v-model="
                                                        editedItem.finance_partner
                                                    "
                                                    label="Partners Name"
                                                    dense
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field
                                                    :readonly="detailsReadonly"
                                                    :rules="[rules.number]"
                                                    ref="refBudget"
                                                    v-on:keyup="computeBurnRate"
                                                    v-model="
                                                        editedItem.finance_budget
                                                    "
                                                    label="Budget"
                                                    dense
                                                >
                                                </v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field
                                                    :readonly="detailsReadonly"
                                                    :rules="[rules.number]"
                                                    v-model="
                                                        editedItem.finance_tranche1
                                                    "
                                                    label="1st Tranche"
                                                    v-on:keyup="computeBurnRate"
                                                    dense
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field
                                                    v-if="
                                                        editedItem.finance_tranche1 !=
                                                            0.00
                                                    "
                                                    v-on:keyup="computeBurnRate"
                                                    :readonly="detailsReadonly"
                                                    :rules="[rules.number]"
                                                    v-model="
                                                        editedItem.finance_tranche2
                                                    "
                                                    label="2nd Tranche"
                                                    dense
                                                ></v-text-field>
                                                <v-text-field
                                                    v-else
                                                    disabled
                                                    :readonly="detailsReadonly"
                                                    :rules="[rules.number]"
                                                    v-model="
                                                        editedItem.finance_tranche2
                                                    "
                                                    label="2nd Tranche"
                                                    dense
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field
                                                    v-if="
                                                        editedItem.finance_tranche2 !=
                                                            0.00
                                                    "
                                                    v-on:keyup="computeBurnRate"
                                                    :readonly="detailsReadonly"
                                                    :rules="[rules.number]"
                                                    v-model="
                                                        editedItem.finance_tranche3
                                                    "
                                                    label="3rd Tranche"
                                                    dense
                                                ></v-text-field>
                                                <v-text-field
                                                    v-else
                                                    disabled
                                                    :readonly="detailsReadonly"
                                                    :rules="[rules.number]"
                                                    v-model="
                                                        editedItem.finance_tranche3
                                                    "
                                                    label="3rd Tranche"
                                                    dense
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field
                                                v-if="
                                                        editedItem.finance_tranche3 !=
                                                            0.00
                                                    "
                                                    v-on:keyup="computeBurnRate"
                                                    :readonly="detailsReadonly"
                                                    :rules="[rules.number]"
                                                    v-model="
                                                        editedItem.finance_tranche4
                                                    "
                                                    label="4th Tranche"
                                                    dense
                                                ></v-text-field>
                                                <v-text-field
                                                v-else
                                                disabled
                                                    :readonly="detailsReadonly"
                                                    :rules="[rules.number]"
                                                    v-model="
                                                        editedItem.finance_tranche4
                                                    "
                                                    label="4th Tranche"
                                                    dense
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field
                                                    :readonly="detailsReadonly"
                                                    :rules="[rules.number]"
                                                    v-model="
                                                        editedItem.finance_retention
                                                    "
                                                    label="Retention"
                                                    dense
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row
                                            class="mt-0"
                                            v-if="detailsReadonly"
                                        >
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field
                                                    v-model="
                                                        editedItem.finance_total
                                                    "
                                                    label="Total"
                                                    dense
                                                    filled
                                                    disabled
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field
                                                    :readonly="detailsReadonly"
                                                    :rules="[rules.number]"
                                                    v-model="
                                                        editedItem.finance_actuals
                                                    "
                                                    label="Actuals"
                                                    dense
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row
                                            class="mt-0"
                                            v-if="detailsReadonly"
                                        >
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field
                                                    v-model="
                                                        editedItem.finance_variance
                                                    "
                                                    label="Variance"
                                                    dense
                                                    filled
                                                    disabled
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field
                                                    :readonly="detailsReadonly"
                                                    :rules="[rules.number]"
                                                    v-model="
                                                        editedItem.finance_burn1
                                                    "
                                                    label="Burn Rate (1st Liq)"
                                                    dense
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field
                                                    :readonly="detailsReadonly"
                                                    :rules="[rules.number]"
                                                    v-model="
                                                        editedItem.finance_burn2
                                                    "
                                                    label="Burn Rate (2nd Liq)"
                                                    dense
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field
                                                    :readonly="detailsReadonly"
                                                    :rules="[rules.number]"
                                                    v-model="
                                                        editedItem.finance_burn3
                                                    "
                                                    label="Burn Rate (3rd Liq)"
                                                    dense
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field
                                                    :readonly="detailsReadonly"
                                                    :rules="[rules.number]"
                                                    v-model="
                                                        editedItem.finance_burn4
                                                    "
                                                    label="Burn Rate (4th Liq)"
                                                    dense
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row
                                            class="mt-0"
                                            v-if="detailsReadonly"
                                        >
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field
                                                    v-model="
                                                        editedItem.finance_burn_rate
                                                    "
                                                    label="Burn Rate (Total)"
                                                    dense
                                                    filled
                                                    disabled
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                </v-card-text>

                                <v-card-actions v-if="!detailsReadonly">
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        color="blue darken-1"
                                        text
                                        @click="close"
                                        dense
                                    >
                                        Cancel
                                    </v-btn>
                                    <v-btn
                                        color="blue darken-1"
                                        text
                                        @click="save"
                                        dense
                                        :loading="btnLoader"
                                    >
                                        Save
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        <v-dialog v-model="dialogDelete" max-width="500px">
                            <v-card>
                                <v-card-title class="text-h5"
                                    >Are you sure you want to delete this
                                    item?</v-card-title
                                >
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        color="blue darken-1"
                                        text
                                        @click="closeDelete"
                                        >Cancel</v-btn
                                    >
                                    <v-btn
                                        color="blue darken-1"
                                        text
                                        @click="deleteItemConfirm"
                                        :loading="btnLoader"
                                        >OK</v-btn
                                    >
                                    <v-spacer></v-spacer>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        &nbsp;&nbsp;
                        <v-btn
                            color="lightgray"
                            class="mb-2"
                            :loading="btnLoader"
                            @click="exportExcel('Finance Tracker', '')"
                        >
                            Export
                            <v-icon color="green">mdi-microsoft-excel</v-icon>
                        </v-btn>
                    </v-toolbar>
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
                    <v-icon
                        small
                        class="mr-2"
                        @click="detailsItem(item)"
                        color="blue"
                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Finance Tracker Details"
                    >
                        mdi-information-outline
                    </v-icon>
                    <v-icon
                        small
                        class="mr-2"
                        @click="editItem(item)"
                        color="blue darken-2"
                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Edit Finance Tracker"
                    >
                        mdi-pencil
                    </v-icon>
                    <v-icon small @click="deleteItem(item)" color="red" data-toggle="tooltip"
                    data-placement="top"
                    title="Delete This Item"
                        mdi-delete
                        
                    </v-icon>
                </template>
            </v-data-table>
        </v-card>
    </v-app>
</template>
<script>
export default {
    data: vm => ({
        btnLoader: false,
        dialog: false,
        dialogDelete: false,
        loadFinanceTracker: false,
        detailsReadonly: false,
        modelAssessmentDate: false,
        cso_name_items: [],
        status_list: [],
        searchBy: "",
        headers: [
            {
                text: "Name",
                align: "start",
                sortable: false,
                value: "finance_name",
                width: "12%"
            },
            {
                text: "Location",
                value: "finance_location",
                width: "8%",
                sortable: false
            },
            {
                text: "Cost Center",
                value: "finance_cost_center",
                width: "8%",
                sortable: false
            },
            {
                text: "Project Code",
                value: "finance_project_code",
                width: "8%",
                sortable: false
            },
            { text: "SOF", value: "finance_sof", width: "8%", sortable: false },
            { text: "DEA", value: "finance_dea", width: "8%", sortable: false },
            {
                text: "Budget",
                value: "finance_budget",
                width: "8%",
                sortable: false,
                align: "end"
            },
            {
                text: "Actuals",
                value: "finance_actuals",
                width: "8%",
                sortable: false,
                align: "end"
            },
            {
                text: "Variance",
                value: "finance_variance",
                width: "8%",
                sortable: false,
                align: "end"
            },
            {
                text: "BR Total",
                value: "finance_burn_rate",
                width: "8%",
                sortable: false,
                align: "end"
            },
            { text: "Actions", value: "actions", width: "8%", sortable: false }
        ],
        financeList: [],
        editedIndex: -1,
        editedItem: {
            finance_name: "",
            finance_code: "",
            finance_location: "",
            finance_cost_center: "",
            finance_project_code: "",
            finance_sof: "",
            finance_dea: "",
            finance_partner: "",
            finance_budget: "",
            finance_tranche1: "",
            finance_tranche2: "",
            finance_tranche3: "",
            finance_tranche4: "",
            finance_retention: "",
            finance_total: "",
            finance_actuals: "",
            finance_variance: "",
            finance_burn1: "",
            finance_burn2: "",
            finance_burn3: "",
            finance_burn4: "",
            finance_burn_rate: ""
        },
        defaultItem: {
            finance_name: "",
            finance_code: "",
            finance_location: "",
            finance_cost_center: "",
            finance_project_code: "",
            finance_sof: "",
            finance_dea: "",
            finance_partner: "",
            finance_budget: "",
            finance_tranche1: "",
            finance_tranche2: "",
            finance_tranche3: "",
            finance_tranche4: "",
            finance_retention: "",
            finance_total: "",
            finance_actuals: "",
            finance_variance: "",
            finance_burn1: "",
            finance_burn2: "",
            finance_burn3: "",
            finance_burn4: "",
            finance_burn_rate: ""
        },
        delete_finance: "",
        rules: {
            required: v => !!v || "This field is required",
            number: v => {
                if (!v.trim()) return true;
                if (!isNaN(parseFloat(v)) && v >= 0) return true;
                return "The value entered was not valid.";
            }
        }
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1
                ? "New Finance Tracker"
                : "Edit Finance Tracker";
        }
    },

    watch: {
        dialog(val) {
            val || this.close();
        },
        dialogDelete(val) {
            val || this.closeDelete();
        }
    },

    created() {
        this.initialize();
    },

    methods: {

        initialize () {
            document.title = "CSO | Finance Tracker"
            this.loadFinanceTracker = true;
            axios.get("/finance-tracker").then(response => {
                this.financeList = response.data;
                this.loadFinanceTracker = false;
            });
        },
        detailsItem(item) {
            this.detailsReadonly = true;
            this.editedIndex = this.financeList.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
            this.computeBurnRate();
        },
        editItem(item) {
            this.editedIndex = this.financeList.indexOf(item);
            this.editedItem = Object.assign({}, item);
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
                    delete_id: this.delete_finance
                })
                .then(response => {
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
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
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
            if (!this.editedItem.finance_code) {
                this.$noty.error("Code is empty!");
                validate = false;
            }
            if (!this.editedItem.finance_name) {
                this.$noty.error("Name is empty!");
                validate = false;
            }
            if (validate) {
                axios
                    .post("/save-finance-tracker", {
                        data: JSON.stringify(this.editedItem),
                        form_mode: this.editedIndex
                    })
                    .then(response => {
                        if (response.data.success) {
                            this.initialize();
                            if (this.editedIndex < 0) {
                                this.$noty.success("Successfully Added.");
                            } else {
                                this.$noty.success("Successfully Updated.");
                            }
                            this.close();
                        } else {
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
        computeBurnRate: function() {
            var CpyItm = this.editedItem;
            this.editedItem.finance_burn1 = this.getBurn(
                parseFloat(CpyItm.finance_tranche1),
                CpyItm.finance_budget
            );
            this.editedItem.finance_burn2 = this.getBurn(
                (parseFloat(CpyItm.finance_tranche1) + parseFloat(CpyItm.finance_tranche2)),
                CpyItm.finance_budget
            );
            this.editedItem.finance_burn3 = this.getBurn(
                (parseFloat(CpyItm.finance_tranche1) + parseFloat(CpyItm.finance_tranche2) + parseFloat(CpyItm.finance_tranche3)),
                CpyItm.finance_budget
            );
            this.editedItem.finance_burn4 = this.getBurn(
                (parseFloat(CpyItm.finance_tranche1) + parseFloat(CpyItm.finance_tranche2) + parseFloat(CpyItm.finance_tranche3) + parseFloat(CpyItm.finance_tranche4)),
                CpyItm.finance_budget
            );
        },
        formatAsCurrency: function(amt, dec) {
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
                        "" +
                        _amt[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") +
                        "." +
                        _amt[1]
                    );
                }
            } else {
                amt = 0;
                amt = amt.toFixed(dec);
                var _amt = amt.toString().split(".", 2);
                return (
                    "" +
                    _amt[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".") +
                    "." +
                    _amt[1]
                );
            }
        },

        exportExcel: function(tableName, value) {
            this.btnLoader = true;
            let filename = tableName + ".xlsx";
            var formData = new FormData();
            formData.append("tableName", tableName);
            axios
                .post("/export-excel", formData, { responseType: "blob" })
                .then(response => {
                    const url = window.URL.createObjectURL(
                        new Blob([response.data])
                    );
                    const link = document.createElement("a");
                    link.href = url;
                    link.setAttribute("download", filename);
                    document.body.appendChild(link);
                    link.click();
                    this.btnLoader = false;
                });
        }
    }
};
</script>
