<template>
    <v-app>
        <h3 class="subheading grey--text">CSO Network Members Profile</h3>
        <br />
        <v-card>
            <v-data-table :headers="headers" :items="cso_profile_list" :loading="loadCSOProfile"
                :search="filters.filter_items[filters.filter_items_active].value" :custom-filter="filterItems"
                class="elevation-1">
                <template v-slot:top>
                    <v-toolbar flat>
                        <v-spacer></v-spacer>
                        <v-dialog v-model="dialog" max-width="1200px">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn v-show="crud_guard.create" color="lightgray" class="mb-2" v-bind="attrs"
                                    v-on="on">
                                    New
                                    <v-icon color="green">mdi-plus-thick</v-icon>
                                </v-btn>
                            </template>
                            <v-card>
                                <v-card-title class="text-h5 font-weight-regular blue-grey darken-3 white--text">
                                    <span class="text-h5" v-if="!detailsReadonly">{{formTitle }}</span>
                                    <span class="text-h5" v-else>CSO Profile Details</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-container>
                                        <h5 class="subheading font-weight-black">
                                            CSO/CSO Network Basic Information
                                        </h5>
                                        <v-row class="mt-0" v-if="!detailsReadonly && isEditting">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field v-model="editedItem.cso_id" label="CSO ID" dense
                                                    :rules="[rules.required]"></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <!---------------------------------------------------------------->
                                        <!---------------------------------------------------------------->
                                        <!---------------------------------------------------------------->
                                        <!---------------------------------------------------------------->
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field :readonly="detailsReadonly" v-model="editedItem.cso_year"
                                                    label="Year Established" dense></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field :readonly="detailsReadonly" v-model="editedItem.cso_sec_registration_no"
                                                    label="SEC Registration Number" dense></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-combobox :readonly="detailsReadonly"
                                                    v-model="editedItem.cso_registration" :items="accreditations"
                                                    label="Registration with/Accreditation" multiple>
                                                </v-combobox>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-textarea auto-grow rows="1" :readonly="detailsReadonly"
                                                    v-model="editedItem.cso_description"
                                                    label="Brief CSO/CSO Network description (Vision/Mission). " dense>
                                                </v-textarea>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-textarea auto-grow rows="1" :readonly="detailsReadonly"
                                                    v-model="editedItem.cso_core_service"
                                                    label="Core Service and Programs (i.e. policy advocacy, training, research)" dense>
                                                </v-textarea>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-textarea auto-grow rows="1" :readonly="detailsReadonly"
                                                    v-model="editedItem.cso_thematic_areas"
                                                    label="Thematic Areas of Work (i.e. climate, gender, housing, etc.)" dense>
                                                </v-textarea>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field :readonly="detailsReadonly"
                                                    v-model="editedItem.cso_beneficiaries" label="Beneficiaries" dense>
                                                </v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field :readonly="detailsReadonly"
                                                    v-model="editedItem.cso_membership_non_government" label="Membership in Networks, Alliances, Consortia (Non-Government)" dense>
                                                </v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field :readonly="detailsReadonly"
                                                    v-model="editedItem.cso_membership_government" label=" Membership in local initiated local bodies, Technical Working Groups, etc. (Government)" dense>
                                                </v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field :readonly="detailsReadonly"
                                                    v-model="editedItem.cso_current_donors" label="  Current Donors (Institutional Aid Agencies, Private Sector Groups, Government)" dense>
                                                </v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <div class="overline text-left">
                                                    <vuetify-money
                                                        v-model="editedItem.cso_size_funding_portfolio" 
                                                        label="Size of Funding Portfolio (in PhP) : "
                                                        v-bind:options="cso_size_funding_portfolio_options"  
                                                    />
                                                </div>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <div class="overline text-left">
                                                    <v-text-field :readonly="detailsReadonly" :rules="[rules.number]"
                                                        v-model="editedItem.cso_number_staff" label="Number of staffs"
                                                            dense>
                                                    </v-text-field>
                                                </div>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <div class="overline text-left">
                                                    <v-text-field :readonly="detailsReadonly" :rules="[rules.number]"
                                                        v-model="editedItem.cso_number_networ_members" label=" Number of Network Members (if applicable)"
                                                            dense>
                                                    </v-text-field>
                                                </div>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-combobox v-model="editedItem.cso_stakeholders"
                                                    :items="stakeholders"
                                                    label="Which stakeholders do you primarily work with? (Select that applies.)"
                                                    multiple :readonly="detailsReadonly"></v-combobox>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0" v-if="!detailsReadonly">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-select :items="isLRO_list" v-model="editedItem.is_lro"
                                                    label="Is LRO? *" dense :rules="[rules.required]"></v-select>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0" v-if="detailsReadonly">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field v-model="editedItem.is_lro" label="Is LRO? *" dense
                                                    readonly></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0" v-if="!detailsReadonly">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-select :items="type_of_support_list"
                                                    v-model="editedItem.type_of_support" label="Types Of Support" dense
                                                    :rules="[rules.required]"></v-select>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0" v-if="detailsReadonly">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field v-model="editedItem.type_of_support"
                                                    label="Types of support " dense readonly></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field :readonly="detailsReadonly" v-model="editedItem.cso_name"
                                                    :rules="[rules.required]" label="Full name of the CSO/CSO Network *"
                                                    dense></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0" v-if="!detailsReadonly">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-select :items="cso_type_list" v-model="editedItem.cso_type"
                                                    label="Type of CSO/CSO Network *" dense :rules="[rules.required]">
                                                </v-select>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0" v-if="detailsReadonly">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field v-model="editedItem.cso_type"
                                                    label="Type of CSO/CSO Network *" dense readonly></v-text-field>
                                            </v-col>
                                        </v-row>   
                                        <!---------------------------------------------------------------->
                                        <!---------------------------------------------------------------->
                                        <!---------------------------------------------------------------->
                                        <!---------------------------------------------------------------->
                                    </v-container>
                                </v-card-text>

                                <v-card-actions class=" blue-grey darken-3 white--text">
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue lighten-5" text @click="close">
                                        Cancel
                                    </v-btn>
                                    <v-btn color="blue lighten-5" text @click="save" :loading="btnLoader">
                                        Save
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        <v-dialog v-model="dialogDelete" max-width="500px">
                            <v-card color="blue-grey darken-3">
                                <v-alert text color="red lighten-3" prominent type="error" icon="mdi-alert">Are you sure
                                    you want to delete this item?</v-alert>
                                <!-- <v-card-title class="text-h5 white--text">Are you sure you want to delete this item?</v-card-title> -->
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
                        <v-btn color="lightgray" v-show="crud_guard.export" class="mb-2" :loading="btnLoader"
                            @click="exportExcel('CSOProfile', '')">
                            Export
                            <v-icon color="green">mdi-microsoft-excel</v-icon>
                        </v-btn>
                    </v-toolbar>
                    <v-row no-gutters style="flex-wrap: nowrap">
                        <v-col cols="2" class="flex-grow-0 flex-shrink-0">
                            <v-text-field v-model="filters.filter_items['cso_id'].value"
                                :label="filters.filter_items['cso_id'].text" @input="changeFilterActiveValue('cso_id')"
                                append-icon="mdi-magnify" outlined hide-details></v-text-field>
                        </v-col>
                        <v-col cols="4" style="min-width: 100px; max-width: 50%" class="flex-grow-1 flex-shrink-0">
                            <v-text-field v-model="filters.filter_items['cso_name'].value"
                                :label="filters.filter_items['cso_name'].text"
                                @input="changeFilterActiveValue('cso_name')" append-icon="mdi-magnify" outlined
                                hide-details></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row no-gutters style="flex-wrap: nowrap" class="my-3">
                        <v-col cols="1" style="min-width: 100px; max-width: 70%" class="flex-grow-1 flex-shrink-0">
                            <v-select v-model="filters.filter_items['cso_type'].value"
                                :label="filters.filter_items['cso_type'].text"
                                :items="filters.filter_items['cso_type'].multiple_selection"
                                @input="changeFilterActiveValue('cso_type')" outlined hide-details></v-select>
                        </v-col>
                        <v-col cols="1" style="min-width: 100px; max-width: 70%" class="flex-grow-1 flex-shrink-0">
                            <v-select v-model="filters.filter_items['is_lro'].value"
                                :label="filters.filter_items['is_lro'].text"
                                :items="filters.filter_items['is_lro'].multiple_selection"
                                @input="changeFilterActiveValue('is_lro')" outlined hide-details></v-select>
                        </v-col>
                    </v-row>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-icon small class="mr-2" @click="detailsItem(item)" color="blue" data-toggle="tooltip"
                        data-placement="top" title="CSO Profile Details" v-show="crud_guard.view">
                        mdi-information-outline
                    </v-icon>
                    <v-icon small class="mr-2" @click="editItem(item)" color="blue darken-2" data-toggle="tooltip"
                        data-placement="top" title="Edit CSO Profile" v-show="crud_guard.update">
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
    import VueNumeric from "vue-numeric";
    const days360 = require("days360");
    import ProjectTrackingDocumentModal from "./ProjectTrackingModal";
    import VueApexCharts from "vue-apexcharts";

    import Vue from "vue";
    import VueNoty from "vuejs-noty";
    Vue.use(VueNoty);
    export default {
        components: {
            VueNumeric
        },
        data: () => ({
            btnLoader: false,
            dialog: false,
            detailsReadonly: false,
            dialogDelete: false,
            loadCSOProfile: false,
            searchBy: "",
            isEditting: false,
            isAddingNew: false,
            editedItemCopy: {},
            cso_size_funding_portfolio_options: {
                locale: "en-US",
                prefix: "₱",
                suffix: "",
                length: 11,
                precision: 2,
            },
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
            stakeholders: [],
            accreditations: [],
            isLRO_list: [{
                    value: "Yes",
                    text: "Yes"
                },
                {
                    value: "No",
                    text: "No"
                },
            ],
            isLROSupported_list: [{
                    value: "Yes",
                    text: "Yes"
                },
                {
                    value: "No",
                    text: "No"
                },
            ],
            type_of_support_list: [],
            cso_type_list: [{
                    value: "Stand alone",
                    text: "Stand alone"
                },
                {
                    value: "Member-based (Individuals)",
                    text: "Member-based (Individuals)",
                },
                {
                    value: "Member-based (Organization)",
                    text: "Member-based (Organization)",
                },
            ],
            level_list: [{
                    value: "1",
                    text: "1"
                },
                {
                    value: "2",
                    text: "2"
                },
                {
                    value: "3",
                    text: "3"
                },
                {
                    value: "4",
                    text: "4"
                },
                {
                    value: "5",
                    text: "5"
                },
            ],
            filters: {
                filter_items_active: "cso_id",
                filter_items: {
                    cso_id: {
                        value: "",
                        text: "Id",
                        data_value: "cso_id",
                        specific: true,
                    },
                    cso_name: {
                        value: "",
                        text: "Name",
                        data_value: "cso_name",
                    },
                    cso_type: {
                        value: "",
                        text: "CSO Type",
                        data_value: "cso_type",
                        multiple_selection: [{
                                text: "None",
                                value: ""
                            },
                            {
                                value: "Stand alone",
                                text: "Stand alone"
                            },
                            {
                                value: "Member-based (Individuals)",
                                text: "Member-based (Individuals)",
                            },
                            {
                                value: "Member-based (Organization)",
                                text: "Member-based (Organization)",
                            },
                        ],
                    },
                    is_lro: {
                        value: "",
                        text: "Is LRO",
                        data_value: "is_lro",
                        multiple_selection: [{
                                text: "None",
                                value: ""
                            },
                            {
                                value: "Yes",
                                text: "Yes"
                            },
                            {
                                value: "No",
                                text: "No"
                            },
                        ],
                    },
                },
            },
            headers: [{
                    text: "CSO ID",
                    align: "start",
                    sortable: false,
                    value: "cso_id",
                    width: "10%",
                },
                {
                    text: "Name",
                    align: "start",
                    sortable: false,
                    value: "cso_name",
                    width: "25%",
                },
                {
                    text: "Type of CSO",
                    value: "cso_type",
                    width: "10%",
                    sortable: false
                },
                {
                    text: "Is LRO?",
                    value: "is_lro",
                    width: "10%",
                    sortable: false
                },
                {
                    text: "Actions",
                    value: "actions",
                    width: "10%",
                    sortable: false
                },
            ],
            cso_profile_list: [],
            editedIndex: -1,
            editedItem: {
                cso_id: "",
                cso_year: "",
                cso_sec_registration_no:"",
                cso_registration: "",
                cso_description: "",
                cso_core_service:"",
                cso_thematic_areas:"",
                cso_beneficiaries: "",
                cso_membership_non_government:"",
                cso_membership_government:"",
                cso_current_donors:"",
                cso_size_funding_portfolio:"",
                cso_number_staff:"",
                cso_number_networ_members:"",
                cso_stakeholders: "",
                is_lro: "",
                type_of_support: "",
                cso_name: "",
                cso_type: "",

            },
            defaultItem: {
                cso_id: "",
                cso_year: "",
                cso_sec_registration_no:"",
                cso_registration: "",
                cso_description: "",
                cso_core_service:"",
                cso_thematic_areas:"",
                cso_beneficiaries: "",
                cso_membership_non_government:"",
                cso_membership_government:"",
                cso_current_donors:"",
                cso_size_funding_portfolio:"",
                cso_number_staff:"",
                cso_number_networ_members:"",
                cso_stakeholders: "",
                is_lro: "",
                type_of_support: "",
                cso_name: "",
                cso_type: "",
            },

            rules: {
                required: (v) => !!v || "This field is required",
                number: (v) => {
                    if (!isNaN(v)) return true;
                    if (!isNaN(v) && v.toString().indexOf(".") != -1)
                        return "The value entered was not valid.";
                    if (!isNaN(parseFloat(v)) && v >= 0) return true;
                    return "The value entered was not valid.";
                },
            },
        }),

        computed: {
            formTitle() {
                return this.editedIndex === -1 ? "New CSO Profile" : "Edit CSO Profile";
            },
        },

        watch: {
            dialog(val) {
                val || this.close();
            },
            dialogDelete(val) {
                val || this.closeDelete();
            },
        },

        created() {
            this.initialize();
        },

        methods: {
            initialize() {
                document.title = "SCP: CSO² Project | CSO Network Members Profile";
                this.loadCSOProfile = true;
                axios.get("/user-roles-permission").then((response) => {
                    const moduleName = "CSOProfile";
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
                axios.get("/getStakeHolders").then((response) => {
                    this.stakeholders = response.data;
                });
                axios.get("/getAccreditations").then((response) => {
                    this.accreditations = response.data;
                });
                axios.get("/cso-profile").then((response) => {
                    var toParse = response.data;
                    toParse.forEach((i) => {
                        var parsed = i.cso_stakeholders.split("^^");
                        var parsed2 = i.cso_registration.split("^^");

                        var constructed = [];
                        var constructed2 = [];

                        parsed.forEach((item) => {
                            if (item.length === 0) return;
                            constructed.push({
                                value: item,
                                text: item
                            });
                        });

                        parsed2.forEach((item) => {
                            if (item.length === 0) return;
                            constructed2.push({
                                value: item,
                                text: item
                            });
                        });

                        i.cso_stakeholders = constructed;
                        i.cso_registration = constructed2;
                    });

                    this.cso_profile_list = toParse;
                    this.loadCSOProfile = false;
                });
                axios.get("/types-of-support").then((response) => {
                    const data = response.data;
                    var category = [];
                    for (const value in data)
                        category.push({
                            text: data[value].name,
                            value: data[value].name
                        });
                    this.type_of_support_list = category;
                });
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
            editItem(item) {
                this.editedItemCopy = item;
                this.editedIndex = this.cso_profile_list.indexOf(item);
                this.editedItem = Object.assign({}, item);
                this.dialog = true;
                this.isEditting = true;
            },

            detailsItem(item) {
                this.detailsReadonly = true;
                this.editedIndex = this.cso_profile_list.indexOf(item);
                this.editedItem = Object.assign({}, item);
                // this.hideProjArea = false;
                this.dialog = true;
            },

            deleteItem(item) {
                this.delete_lro = item.cso_profile_id;
                this.editedIndex = this.cso_profile_list.indexOf(item);
                this.editedItem = Object.assign({}, item);
                this.dialogDelete = true;
            },

            deleteItemConfirm() {
                this.btnLoader = true;
                this.cso_profile_list.splice(this.editedIndex, 1);
                axios
                    .post("/delete-cso-profile", {
                        delete_id: this.delete_lro,
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
                this.isEditting = false;
                this.btnLoader = false;
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem);
                    this.editedItemCopy = {};
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
            async checkNoExistCSOProfileID(url, id) {
                try {
                    //console.log(`/${url}/?cso_id=${id}`)
                    const response = await axios.get(`/${url}/?cso_id=${id}`);
                    //console.log(response)
                    const arr = [];

                    for (let x = 0; x < response.data.length; x++) {
                        //console.log(id.replace(/[^\d.-]/g,''),response.data[x].cso_act_no.replace(/[^\d.-]/g,''))
                        if (response.data[x].cso_id)
                            arr[arr.length] = response.data[x].cso_id;
                    }
                    //console.log(arr);

                    if (arr.length !== 0) {
                        //console.log(arr.length, "returning true")
                        return true;
                    } else {
                        //console.log(arr.length, "returning false")
                        return false;
                    }
                } catch (error) {
                    console.log(error);
                }
            },
            async save() {
                this.btnLoader = true;
                let validate = true;

                if (this.isEditting) {
                    let check = await this.checkNoExistCSOProfileID(
                        "checkNoExistCSOProfileID",
                        this.editedItem.cso_id
                    );
                    if (check && this.editedItemCopy.cso_id != this.editedItem.cso_id) {
                        validate = false;
                        this.$noty.error("CSO ID already exist");
                    }
                }
                if (!this.editedItem.is_lro) {
                    this.$noty.error("Is LRO is empty!");
                    validate = false;
                }
                if (!this.editedItem.type_of_support) {
                    this.$noty.error("type of support is empty!");
                    validate = false;
                }
                if (!this.editedItem.cso_name) {
                    this.$noty.error("Full Name of the CSO/CSO Network is empty!");
                    validate = false;
                }
                if (!this.editedItem.cso_type) {
                    this.$noty.error("Type of CSO/CSO Network is empty!");
                    validate = false;
                }
                if (validate) {
                    // we cant edit editedItem directly because it is bind to combobox which require
                    // an array, so we made a copy
                    var editedITEM = Object.assign({}, this.editedItem);
                    var t = "",
                        t2 = "";

                    editedITEM.cso_stakeholders.forEach((stakeholder) => {
                        t += "^^" + stakeholder.text;
                    });
                    editedITEM.cso_registration.forEach((registration) => {
                        t2 += "^^" + registration.text;
                    });

                    editedITEM.cso_stakeholders = t.substring(2);
                    editedITEM.cso_registration = t2.substring(2);

                    axios
                        .post("/save-cso-profile", {
                            data: JSON.stringify(editedITEM),
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
                                this.close();
                            }
                            this.btnLoader = false;
                        });
                } else {
                    this.btnLoader = false;
                }
            },
            exportExcel: function (tableName, value) {
                //console.log(tableName)
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
