<template>
    <v-card>
        <v-data-table :headers="headers" :items="lmsList"
            :search="filters.filter_items[filters.filter_items_active].value" :loading="loadLMS"
            :custom-filter="filterItems" class="elevation-1">
            <template v-slot:top>
                <v-toolbar flat>
                    <v-spacer></v-spacer>
                    <v-dialog v-model="dialog" max-width="500px">
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn color="lightgray" class="mb-2" v-bind="attrs" v-on="on" v-show="crud_guard.create">
                                New
                                <v-icon color="green">mdi-plus-thick</v-icon>
                            </v-btn>
                        </template>
                        <v-card>
                            <v-card-title class="text-h5 font-weight-regular blue-grey darken-3 white--text">
                                <span class="text-h5" v-if="!detailsReadonly">{{formTitle}}</span>
                                <span class="text-h5" v-else>LMS Details</span>
                            </v-card-title>

                            <v-card-text>
                                <v-container dense>
                                    <v-row class="mt-0">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field :readonly="detailsReadonly" :rules="[rules.required]"
                                                v-model="editedItem.participant_name" label="Name *" dense>
                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field :readonly="detailsReadonly" :rules="[rules.required]"
                                                v-model="editedItem.participant_location" label="Location *" dense>
                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field :readonly="detailsReadonly" :rules="[rules.required]"
                                                v-model="editedItem.participant_address" label="Address *" dense>
                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field :readonly="detailsReadonly" :rules="[rules.required]"
                                                v-model="editedItem.participant_position" label="Position *" dense>
                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0" v-if="!detailsReadonly">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-select :items="genderList" v-model="editedItem.participant_gender"
                                                :rules="[rules.required]" label="Gender *" dense></v-select>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0" v-if="detailsReadonly">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field v-model="editedItem.participant_gender" label="Gender *" dense
                                                readonly></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field v-model="editedItem.participant_age"
                                                :readonly="detailsReadonly" :rules="[rules.number, rules.required]"
                                                label="Age *" dense></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field v-model="editedItem.cso_affiliation"
                                                :readonly="detailsReadonly" :rules="[rules.number]"
                                                label="Name of Organization/Network" dense></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0" v-if="!detailsReadonly">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-menu ref="dateOfTrainingModal" v-model="dateOfTrainingModal"
                                                :close-on-content-click="false" transition="scale-transition" offset-y
                                                max-width="290px" min-width="auto" dense>
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field v-model="editedItem.date_of_training" label="Date of training"
                                                        persistent-hint append-outer-icon="mdi-calendar" v-bind="attrs" v-on="on"
                                                        dense></v-text-field>
                                                </template>
                                                <v-date-picker v-model="editedItem.date_of_training" no-title
                                                    @input="dateOfTrainingModal = false" dense></v-date-picker>
                                            </v-menu>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0" v-if="detailsReadonly">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field v-model="editedItem.date_of_training" label="Date of training" dense
                                                readonly></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <!-- <v-row class="mt-0">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field :readonly="detailsReadonly" :rules="[rules.required]"
                                                v-model="editedItem.participant_skills" label="Skills *" dense>
                                            </v-text-field>
                                        </v-col>
                                    </v-row> -->
                                    <v-row class="mt-0">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field :readonly="detailsReadonly" :rules="[rules.required]"
                                                v-model="editedItem.position_in_organization" label="Position in Organization *" dense>
                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                    
                                    <v-row class="mt-0">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field :readonly="detailsReadonly" :rules="[rules.required]"
                                                v-model="editedItem.name_of_training" label=" Training Course *" dense>
                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field :readonly="detailsReadonly" :rules="[rules.required]"
                                                v-model="editedItem.training_organizer" label="Training organizer *"
                                                dense></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-textarea auto-grow rows="3" :readonly="detailsReadonly"
                                                v-model="editedItem.remarks" label="Remarks" dense></v-textarea>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-text>
                            <v-card-actions class=" blue-grey darken-3 white--text" v-if="!detailsReadonly">
                                <v-spacer></v-spacer>
                                <v-btn color="blue lighten-5" text @click="close" dense>
                                    Cancel
                                </v-btn>
                                <v-btn color="blue lighten-5" text @click="save" :loading="btnLoader" dense>
                                    Save
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <v-dialog v-model="dialogDelete" max-width="500px">
                        <v-card color="blue-grey darken-3">
                            <v-alert text color="red lighten-3" prominent type="error" icon="mdi-alert">Are you sure you
                                want to delete this item?</v-alert>
                            <!-- <v-card-title class="text-h5 white--text">Are you sure you want to delete this item?</v-card-title> -->
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue lighten-5" text @click="closeDelete">No</v-btn>
                                <v-btn color="blue lighten-5" text @click="deleteItemConfirm" :loading="btnLoader">Yes
                                </v-btn>
                                <v-spacer></v-spacer>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    &nbsp;&nbsp;
                    <v-btn color="lightgray" class="mb-2" :loading="btnLoader"
                        @click="exportExcel('Participants Profile', '')" v-show="crud_guard.export">
                        Export
                        <v-icon color="green">mdi-microsoft-excel</v-icon>
                    </v-btn>
                </v-toolbar>
                <v-row no-gutters style="flex-wrap: nowrap">
                    <v-col cols="2" class="flex-grow-0 flex-shrink-0">
                        <v-text-field v-model="filters.filter_items['participant_id'].value"
                            :label="filters.filter_items['participant_id'].text"
                            @input="changeFilterActiveValue('participant_id')" append-icon="mdi-magnify" outlined
                            hide-details></v-text-field>
                    </v-col>
                    <v-col cols="4" style="min-width: 100px; max-width: 50%" class="flex-grow-1 flex-shrink-0">
                        <v-text-field v-model="filters.filter_items['participant_name'].value"
                            :label="filters.filter_items['participant_name'].text"
                            @input="changeFilterActiveValue('participant_name')" append-icon="mdi-magnify" outlined
                            hide-details></v-text-field>
                    </v-col>
                    <v-col cols="1" style="min-width: 100px; max-width: 70%" class="flex-grow-1 flex-shrink-0">
                        <v-select v-model="filters.filter_items['participant_gender'].value"
                            :label="filters.filter_items['participant_gender'].text" :items="filters.filter_items['participant_gender'].multiple_selection" @input="changeFilterActiveValue('participant_gender')" outlined hide-details></v-select>
                    </v-col>
                    <v-col cols="2" style="min-width: 50px" class="flex-grow-0 flex-shrink-1">
                        <div v-if="
                            filters.filter_items['participant_age_selection'].value !='range' ">
                            <v-text-field v-model="filters.filter_items['participant_age'].value"
                                :label="filters.filter_items['participant_age'].text"
                                @input="changeFilterActiveValue('participant_age')" :rules="[rules.number]" outlined
                                hide-details class="ml-3"></v-text-field>
                        </div>
                        <div v-else>
                            <v-text-field v-model="filters.filter_items['participant_age_min'].value"
                                :label="filters.filter_items['participant_age_min'].text"
                                @input="changeFilterActiveValue('participant_age_min')" :rules="[rules.number]" outlined
                                hide-details class="ml-3"></v-text-field>
                            <v-text-field v-model="filters.filter_items['participant_age_max'].value"
                                :label="filters.filter_items['participant_age_max'].text"
                                @input="changeFilterActiveValue('participant_age_max')" :rules="[rules.number]" outlined
                                hide-details class="ml-3"></v-text-field>
                        </div>
                    </v-col>
                    <v-col cols="2" style="min-width: 100px; max-width: 50%" class="flex-grow-1 flex-shrink-0">
                        <v-select v-model="filters.filter_items['participant_age_selection'].value"
                            :label="filters.filter_items['participant_age_selection'].text" :items="filters.filter_items['participant_age_selection'].multiple_selection" @input="changeFilterActiveValue('participant_age_selection')" outlined></v-select>
                    </v-col>
                </v-row>
                <v-row no-gutters style="flex-wrap: nowrap">
                    <v-col cols="3" style="min-width: 100px; max-width: 50%" class="flex-grow-1 flex-shrink-0">
                        <v-text-field v-model="filters.filter_items['name_of_training'].value"
                            :label="filters.filter_items['name_of_training'].text"
                            @input="changeFilterActiveValue('name_of_training')" append-icon="mdi-magnify" outlined
                            hide-details></v-text-field>
                    </v-col>
                    <v-col cols="4" style="min-width: 100px; max-width: 50%" class="flex-grow-1 flex-shrink-0">
                        <v-text-field v-model="filters.filter_items['training_organizer'].value"
                            :label="filters.filter_items['training_organizer'].text"
                            @input="changeFilterActiveValue('training_organizer')" append-icon="mdi-magnify" outlined
                            hide-details></v-text-field>
                    </v-col>
                    <v-col cols="2" style="min-width: 100px; max-width: 50%" class="flex-grow-1 flex-shrink-0">
                        <v-text-field v-model="filters.filter_items['participant_location'].value"
                            :label="filters.filter_items['participant_location'].text"
                            @input="changeFilterActiveValue('participant_location')" append-icon="mdi-magnify" outlined
                            hide-details></v-text-field>
                    </v-col>
                    <!-- <v-col cols="2" style="min-width: 100px; max-width: 50%" class="flex-grow-1 flex-shrink-0">
                        <v-text-field v-model="filters.filter_items['participant_skills'].value"
                            :label="filters.filter_items['participant_skills'].text"
                            @input="changeFilterActiveValue('participant_skills')" append-icon="mdi-magnify" outlined
                            hide-details></v-text-field>
                    </v-col> -->
                </v-row>
            </template>
            <template v-slot:[`item.actions`]="{ item }">
                <v-icon small class="mr-2" @click="detailsItem(item)" color="blue" data-toggle="tooltip"
                    data-placement="top" title="LMS Profile" v-show="crud_guard.view">
                    mdi-information-outline
                </v-icon>
                <v-icon small class="mr-2" @click="editItem(item)" color="blue darken-2" data-toggle="tooltip"
                    data-placement="top" title="Edit LMS" v-show="crud_guard.update">
                    mdi-pencil
                </v-icon>
                <v-icon small @click="deleteItem(item)" color="red" data-toggle="tooltip" data-placement="top"
                    title="Delete This Item" v-show="crud_guard.delete">
                    mdi-delete
                </v-icon>
            </template>
        </v-data-table>
    </v-card>
</template>
<script>
    export default {
        data: (vm) => ({
            LMSTab: null,
            dialog: false,
            btnLoader: false,
            dialogDelete: false,
            loadLMS: false,
            detailsReadonly: false,
            dateOfTrainingModal: false,
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
            genderList: [{
                    value: "Male",
                    text: "Male"
                },
                {
                    value: "Female",
                    text: "Female"
                },
            ],
            // hideProjArea: true,
            cso_name_items: [],
            status_list: [],
            searchBy: "",
            filters: {
                filter_items_active: "participant_name",
                filter_items: {
                    all: {
                        value: "",
                        text: "All",
                        data_value: "all",
                    },
                    participant_id: {
                        value: "",
                        text: "Participant ID",
                        data_value: "participant_id",
                        specific: true,
                    },
                    participant_name: {
                        value: "",
                        text: "Participant Name",
                        data_value: "participant_name",
                    },
                    participant_gender: {
                        value: "",
                        text: "Gender",
                        data_value: "participant_gender",
                        multiple_selection: [{
                                text: "None",
                                value: ""
                            },
                            {
                                value: "Male",
                                text: "Male"
                            },
                            {
                                value: "Female",
                                text: "Female"
                            },
                        ],
                    },

                    // ============================= Age range
                    participant_age: {
                        value: "",
                        text: "Age",
                        data_value: "participant_age",
                        number_range: true, // Enables min and max value (Prerequisits are below)
                    },
                    participant_age_min: {
                        value: "",
                        text: "Age min",
                        data_value: "participant_age_min",
                        inherit_value: "participant_age", // <--------------------------- Needed for the key
                        number_range: true,
                    },
                    participant_age_max: {
                        value: "",
                        text: "Age max",
                        data_value: "participant_age_max",
                        inherit_value: "participant_age", // <--------------------------- Needed for the key
                        number_range: true,
                    },
                    participant_age_selection: {
                        value: "==",
                        text: "Choose value",
                        data_value: "participant_age",
                        inherit_value: "participant_age", // <--------------------------- Needed for the key
                        multiple_selection: [
                            // {
                            //     text: "Range",
                            //     value: "range"
                            // },
                            {
                                text: "Equal to",
                                value: "=="
                            },
                            {
                                text: "Greater than or equal to",
                                value: ">="
                            },
                            {
                                text: "Less than or equal to",
                                value: "<="
                            },
                            {
                                text: "Greater than",
                                value: ">"
                            },
                            {
                                text: "Less than",
                                value: "<"
                            },
                        ],
                    },
                    // ============================= Age range

                    participant_location: {
                        value: "",
                        text: "Participant Location",
                        data_value: "participant_location",
                    },
                    // participant_skills: {
                    //     value: "",
                    //     text: "Participant Skills",
                    //     data_value: "Participant Skills",
                    // },

                    name_of_training: {
                        value: "",
                        text: " Training Course",
                        data_value: "name_of_training",
                    },
                    training_organizer: {
                        value: "",
                        text: "Training Organizer",
                        data_value: "training_organizer",
                    },
                },
            },
            headers: [{
                    text: "Participant ID",
                    align: "start",
                    sortable: false,
                    value: "participant_id",
                    width: "10%",
                },
                {
                    text: "Participant Name",
                    align: "start",
                    sortable: false,
                    value: "participant_name",
                    width: "25%",
                },
                {
                    text: "Name of Organization/Network",
                    align: "start",
                    sortable: false,
                    value: "cso_affiliation",
                    width: "25%",
                },
                {
                    text: "Gender",
                    align: "start",
                    sortable: false,
                    value: "participant_gender",
                    width: "10%",
                },
                {
                    text: "Age",
                    align: "start",
                    sortable: false,
                    value: "participant_age",
                    width: "10%",
                },
                {
                    text: "Location",
                    value: "participant_location",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: " Training Course",
                    value: "name_of_training",
                    width: "25%",
                    sortable: false,
                },
                {
                    text: "Training Organizer",
                    value: "training_organizer",
                    width: "25%",
                    sortable: false,
                },
                // {
                //     text: "Skills",
                //     value: "participant_skills",
                //     width: "15%",
                //     sortable: false,
                // },
                {
                    text: "Position in Organization",
                    value: "position_in_organization",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: "Actions",
                    value: "actions",
                    width: "10%",
                    sortable: false
                },
            ],
            lmsList: [],
            editedIndex: -1,
            editedItem: {
                participant_id: "",
                participant_name: "",
                participant_location: "",
                participant_address: "",
                participant_position: "",
                lro_id: "",
                participant_gender: "",
                participant_age: "",
                cso_affiliation: "",
                date_of_training: "",
                // participant_skills: "",
                position_in_organization:"",
                name_of_training: "",
                training_organizer: "",
                remarks: "",
            },
            defaultItem: {
                participant_id: "",
                participant_name: "",
                participant_location: "",
                participant_address: "",
                participant_position: "",
                lro_id: "",
                participant_gender: "",
                participant_age: "",
                cso_affiliation: "",
                date_of_training: "",
                // participant_skills: "",
                position_in_organization:"",
                name_of_training: "",
                training_organizer: "",
                remarks: "",
            },
            delete_lms: "",
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
                return this.editedIndex === -1 ? "New Participant" : "Edit LMS";
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
                document.title = "SCP: CSO² Project | LMS";
                this.loadLMS = true;
                axios.get("/user-roles-permission").then((response) => {
                    const moduleName = "LMS";
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
                axios.get("/cso-name-list").then((response) => {
                    this.cso_name_items = response.data;
                });

                axios.get("/participants-profile").then((response) => {
                    this.lmsList = response.data;
                    this.loadLMS = false;
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
            detailsItem(item) {
                this.detailsReadonly = true;
                this.editedIndex = this.lmsList.indexOf(item);
                this.editedItem = Object.assign({}, item);
                // this.hideProjArea = false;
                this.dialog = true;
            },
            editItem(item) {
                this.editedIndex = this.lmsList.indexOf(item);
                this.editedItem = Object.assign({}, item);
                // this.hideProjArea = true;
                this.dialog = true;
            },

            deleteItem(item) {
                this.delete_lms = item.participant_id;
                this.editedIndex = this.lmsList.indexOf(item);
                this.editedItem = Object.assign({}, item);
                this.dialogDelete = true;
            },

            deleteItemConfirm() {
                this.btnLoader = true;
                this.lmsList.splice(this.editedIndex, 1);
                //console.log(this.delete_lms)
                axios
                    .post("/delete-participants-profile", {
                        delete_id: this.delete_lms,
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
                this.btnLoader = false;
                this.detailsReadonly = false;
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem);
                    this.editedIndex = -1;
                });
            },

            closeDelete() {
                this.dialogDelete = false;
                this.btnLoader = false;
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem);
                    this.editedIndex = -1;
                });
            },

            save() {
                this.btnLoader = true;
                let validate = true;
                if (!this.editedItem.participant_name) {
                    this.$noty.error("Name is empty!");
                    validate = false;
                }
                if (!this.editedItem.participant_location) {
                    this.$noty.error("Location is empty!");
                    validate = false;
                }
                if (!this.editedItem.participant_address) {
                    this.$noty.error("Address is empty!");
                    validate = false;
                }
                if (!this.editedItem.participant_position) {
                    this.$noty.error("Position is empty!");
                    validate = false;
                }
                if (!this.editedItem.participant_gender) {
                    this.$noty.error("Gender is empty!");
                    validate = false;
                }
                if (!this.editedItem.participant_age) {
                    this.$noty.error("Age is empty!");
                    validate = false;
                }
                // if (!this.editedItem.participant_skills) {
                //     this.$noty.error("Skills is empty!");
                //     validate = false;
                // }
                if (!this.editedItem.name_of_training) {
                    this.$noty.error(" Training Course is empty!");
                    validate = false;
                }
                if (!this.editedItem.training_organizer) {
                    this.$noty.error("Training Organizer is empty!");
                    validate = false;
                }
                if (!this.editedItem.position_in_organization) {
                    this.$noty.error("Position in Organization is empty!");
                    validate = false;
                }
                if (validate) {
                    axios
                        .post("/save-participants-profile", {
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
                                this.close();
                            }
                        });
                } else {
                    this.btnLoader = false;
                }
            },
            exportExcel: function (tableName, value) {
                this.btnLoader = true;
                let filename = tableName + ".xlsx";
                var formData = new FormData();
                formData.append("tableName", tableName);
                formData.append("category", value);
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
