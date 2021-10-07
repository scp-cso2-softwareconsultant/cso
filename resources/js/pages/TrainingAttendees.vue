<template>
    <v-card>
        <v-data-table :headers="headers" :items="trainingList" :search="searchBy" :loading="loadTraining"
            class="elevation-1">
            <template v-slot:top>
                <v-toolbar flat>
                    <v-text-field v-model="searchBy" append-icon="mdi-magnify" label="Search" single-line hide-details>
                    </v-text-field>
                    <v-spacer></v-spacer>
                    <v-dialog v-model="dialog" max-width="500px">
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn color="lightgray" class="mb-2" v-bind="attrs" v-on="on" v-show="crud_guard.create">
                                New
                                <v-icon color="green">mdi-plus-thick</v-icon>
                            </v-btn>
                        </template>
                        <v-card>
                            <v-card-title>
                                <span class="text-h5" v-if="!detailsReadonly">{{ formTitle}}</span>
                                <span class="text-h5" v-else>Training Attendees Details</span>
                            </v-card-title>

                            <v-card-text>
                                <v-container dense>
                                    <v-row class="mt-0" v-if="!detailsReadonly">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-select :items="participant_items" v-model="editedItem.participant_id"
                                                label="Participant Name *" dense :rules="[rules.required]"></v-select>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0" v-if="detailsReadonly">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field v-model="editedItem.participant_name"
                                                label="Participant Name *" dense readonly></v-text-field>
                                        </v-col>
                                    </v-row>

                                    <v-row class="mt-0" v-if="!detailsReadonly">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-select :items="course_items" v-model="editedItem.course_id"
                                                label="Course Name *" dense :rules="[rules.required]"></v-select>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0" v-if="detailsReadonly">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field v-model="editedItem.course_name" label="Course Name *" dense
                                                readonly></v-text-field>
                                        </v-col>
                                    </v-row>

                                    <v-row class="mt-0" v-if="detailsReadonly">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field v-model="editedItem.project_area" label="Course Name *" dense
                                                readonly></v-text-field>
                                        </v-col>
                                    </v-row>

                                    <v-row class="mt-0" v-if="!detailsReadonly">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-menu ref="modelDateStarted" v-model="modelDateStarted"
                                                :close-on-content-click="false" transition="scale-transition" offset-y
                                                max-width="290px" min-width="auto" dense>
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field v-model="editedItem.date_started"
                                                        label="Date Started *" persistent-hint
                                                        append-outer-icon="mdi-calendar" v-bind="attrs" v-on="on" dense
                                                        :rules="[rules.required]"></v-text-field>
                                                </template>
                                                <v-date-picker v-model="editedItem.date_started" no-title
                                                    @input="modelDateStarted = false" dense></v-date-picker>
                                            </v-menu>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0" v-if="detailsReadonly">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field v-model="editedItem.date_started" label="Date Started *" dense
                                                readonly></v-text-field>
                                        </v-col>
                                    </v-row>

                                    <v-row class="mt-0" v-if="!detailsReadonly">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-menu ref="modelDateCompleted" v-model="modelDateCompleted"
                                                :close-on-content-click="false" transition="scale-transition" offset-y
                                                max-width="290px" min-width="auto" dense>
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field v-model="editedItem.date_completed"
                                                        label="Date Completed *" persistent-hint
                                                        append-outer-icon="mdi-calendar" v-bind="attrs" v-on="on" dense
                                                        :rules="[rules.required]"></v-text-field>
                                                </template>
                                                <v-date-picker v-model="editedItem.date_completed" no-title
                                                    @input="modelDateCompleted = false" dense></v-date-picker>
                                            </v-menu>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0" v-if="detailsReadonly">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field v-model="editedItem.date_completed" label="Date Completed *"
                                                dense readonly></v-text-field>
                                        </v-col>
                                    </v-row>

                                    <v-row class="mt-0">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field v-model="editedItem.training_mode" :readonly="detailsReadonly"
                                                :rules="[rules.required]" label="Mode of Training *" dense>
                                            </v-text-field>
                                        </v-col>
                                    </v-row>

                                    <v-row class="mt-0">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field :readonly="detailsReadonly" :rules="[rules.required]"
                                                v-model="editedItem.no_hrs" label="Number of Hours *" dense>
                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field :readonly="detailsReadonly" :rules="[rules.required]"
                                                v-model="editedItem.conducted_by" label="Conducted By *" dense>
                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field :readonly="detailsReadonly" :rules="[rules.required]"
                                                v-model="editedItem.venue" label="Venue *" dense></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-text>

                            <v-card-actions class="d-flex justify-center blue-grey darken-3 white--text"
                                v-if="!detailsReadonly">
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="close" dense>
                                    Cancel
                                </v-btn>
                                <v-btn color="blue darken-1" text @click="save" :loading="btnLoader" dense>
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
                                <v-btn color="blue darken-1" text @click="closeDelete">No</v-btn>
                                <v-btn color="blue darken-1" text @click="deleteItemConfirm" :loading="btnLoader">Yes
                                </v-btn>
                                <v-spacer></v-spacer>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    &nbsp;&nbsp;
                    <v-btn color="lightgray" class="mb-2" :loading="btnLoader"
                        @click="exportExcel('Training Attendees', '')" v-show="crud_guard.export">
                        Export
                        <v-icon color="green">mdi-microsoft-excel</v-icon>
                    </v-btn>
                </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-icon small class="mr-2" @click="detailsItem(item)" color="blue" data-toggle="tooltip"
                    data-placement="top" title="Training Attendees Details" v-show="crud_guard.view">
                    mdi-information-outline
                </v-icon>
                <v-icon small class="mr-2" @click="editItem(item)" color="blue darken-2" data-toggle="tooltip"
                    data-placement="top" title="Edit Training Attendees" v-show="crud_guard.update">
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
            dialog: false,
            btnLoader: false,
            dialogDelete: false,
            loadTraining: false,
            detailsReadonly: false,
            participant_items: [],
            course_items: [],
            searchBy: "",
            modelDateStarted: false,
            modelDateCompleted: false,
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
            headers: [{
                    text: "Participant Name",
                    align: "start",
                    sortable: false,
                    value: "participant_name",
                    width: "25%",
                },
                {
                    text: "Course Name",
                    align: "start",
                    sortable: false,
                    value: "course_name",
                    width: "20%",
                },
                {
                    text: "Project Area",
                    value: "project_area",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: "Date Started",
                    value: "date_started",
                    width: "10%",
                    sortable: false,
                },
                {
                    text: "Date Completed",
                    value: "date_completed",
                    width: "10%",
                    sortable: false,
                },
                {
                    text: "Mode of Training",
                    value: "training_mode",
                    width: "10%",
                    sortable: false,
                },
                {
                    text: "Actions",
                    value: "actions",
                    width: "10%",
                    sortable: false
                },
            ],
            trainingList: [],
            editedIndex: -1,
            editedItem: {
                participant_id: "",
                course_id: "",
                date_started: "",
                date_completed: "",
                training_mode: "",
                no_hrs: "",
                conducted_by: "",
                venue: "",
            },
            defaultItem: {
                participant_id: "",
                course_id: "",
                date_started: "",
                date_completed: "",
                training_mode: "",
                no_hrs: "",
                conducted_by: "",
                venue: "",
            },
            delete_training: "",
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
                return this.editedIndex === -1 ?
                    "New Training Attendees" :
                    "Edit Training Attendees";
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
                this.loadTraining = true;
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
                axios.get("/get-participants").then((response) => {
                    this.participant_items = response.data;
                });

                axios.get("/get-courses").then((response) => {
                    this.course_items = response.data;
                });

                axios.get("/training-attendees").then((response) => {
                    this.trainingList = response.data;
                    this.loadTraining = false;
                });
            },
            detailsItem(item) {
                this.detailsReadonly = true;
                this.editedIndex = this.trainingList.indexOf(item);
                this.editedItem = Object.assign({}, item);
                this.dialog = true;
            },
            editItem(item) {
                this.editedIndex = this.trainingList.indexOf(item);
                this.editedItem = Object.assign({}, item);
                this.dialog = true;
            },

            deleteItem(item) {
                this.delete_training = item.training_id;
                this.editedIndex = this.trainingList.indexOf(item);
                this.editedItem = Object.assign({}, item);
                this.dialogDelete = true;
            },

            deleteItemConfirm() {
                this.btnLoader = true;
                this.trainingList.splice(this.editedIndex, 1);
                axios
                    .post("/delete-training-attendees", {
                        delete_id: this.delete_training,
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
                if (!this.editedItem.participant_id) {
                    this.$noty.error("Participant Name is empty!");
                    validate = false;
                }
                if (!this.editedItem.course_id) {
                    this.$noty.error("Course Name is empty!");
                    validate = false;
                }
                if (!this.editedItem.date_started) {
                    this.$noty.error("Date Started is empty!");
                    validate = false;
                }
                if (!this.editedItem.date_completed) {
                    this.$noty.error("Date Completed is empty!");
                    validate = false;
                }
                if (!this.editedItem.training_mode) {
                    this.$noty.error("Mode of training is empty!");
                    validate = false;
                }
                if (!this.editedItem.no_hrs) {
                    this.$noty.error("Number of hours is empty!");
                    validate = false;
                }
                if (!this.editedItem.conducted_by) {
                    this.$noty.error("Conducted By is empty!");
                    validate = false;
                }
                if (!this.editedItem.venue) {
                    this.$noty.error("Venue is empty!");
                    validate = false;
                }
                if (validate) {
                    axios
                        .post("/save-training-attendees", {
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
