<template>
    <v-card>
        <v-data-table
            :headers="headers"
            :items="lmsList"
            :search="searchBy"
            :loading="loadLMS"
            class="elevation-1"
        >
            <template v-slot:top>
                <v-toolbar
                    flat
                >
                    <v-text-field
                        v-model="searchBy"
                        append-icon="mdi-magnify"
                        label="Search"
                        single-line
                        hide-details
                    ></v-text-field>
                    <v-spacer></v-spacer>
                    <v-dialog
                        v-model="dialog"
                        max-width="500px"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                color="lightgray"
                                class="mb-2"
                                v-bind="attrs"
                                v-on="on"
                            >
                                New
                                <v-icon color="green">mdi-plus-thick</v-icon>
                            </v-btn>
                        </template>
                        <v-card>
                            <v-card-title>
                                <span class="text-h5" v-if="!detailsReadonly">{{ formTitle }}</span>
                                <span class="text-h5" v-else>LMS Details</span>
                            </v-card-title>

                            <v-card-text>
                                <v-container dense >
                                    <v-row class="mt-0">
                                        <v-col cols="12" sm="12" md="12" >
                                            <v-text-field :readonly="detailsReadonly"
                                                          :rules="[rules.required]"
                                                          v-model="editedItem.participant_name" label="Name *" dense></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field :readonly="detailsReadonly"
                                                          :rules="[rules.required]"
                                                          v-model="editedItem.participant_location" label="Location *" dense></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0">
                                        <v-col cols="12" sm="12" md="12" >
                                            <v-text-field :readonly="detailsReadonly"
                                                          :rules="[rules.required]"
                                                          v-model="editedItem.participant_address" label="Address *" dense></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field :readonly="detailsReadonly"
                                                          :rules="[rules.required]"
                                                          v-model="editedItem.participant_position" label="Position *" dense></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0" v-if="!detailsReadonly">
                                        <v-col cols="12" sm="12" md="12"  >
                                            <v-select
                                                :items="cso_name_items"
                                                v-model="editedItem.lro_id"
                                                label="Name of LRO *" dense
                                                :rules="[rules.required]"
                                            ></v-select>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0" v-if="detailsReadonly">
                                        <v-col cols="12" sm="12" md="12"  >
                                            <v-text-field v-model="editedItem.cso_name"
                                                          label="Name of LRO *" dense readonly></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0" v-if="!detailsReadonly">
                                        <v-col cols="12" sm="12" md="12"  >
                                            <v-select
                                                :items="genderList"
                                                v-model="editedItem.participant_gender"
                                                :rules="[rules.required]"
                                                label="Gender *" dense
                                            ></v-select>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0" v-if="detailsReadonly">
                                        <v-col cols="12" sm="12" md="12"  >
                                            <v-text-field v-model="editedItem.participant_gender"

                                                          label="Gender *" dense readonly></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0">
                                        <v-col cols="12" sm="12" md="12" >
                                            <v-text-field v-model="editedItem.participant_age"
                                                          :readonly="detailsReadonly"
                                                          :rules="[rules.number, rules.required]"
                                                          label="Age *" dense></v-text-field>
                                        </v-col>
                                    </v-row>

                                    <v-row class="mt-0">
                                        <v-col cols="12" sm="12" md="12" >
                                            <v-text-field :readonly="detailsReadonly"
                                                          :rules="[rules.required]"
                                                          v-model="editedItem.participant_skills" label="Skills *" dense></v-text-field>
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
                                    :loading="btnLoader"
                                    dense
                                >
                                    Save
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <v-dialog v-model="dialogDelete" max-width="500px">
                        <v-card>
                            <v-card-title class="text-h5">Are you sure you want to delete this item?</v-card-title>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                                <v-btn color="blue darken-1" text @click="deleteItemConfirm" :loading="btnLoader">OK</v-btn>
                                <v-spacer></v-spacer>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    &nbsp;&nbsp;
                        <v-btn color="lightgray"
                                               class="mb-2"
                                               :loading="btnLoader"
                                               @click="exportExcel('Participant Profile','')" >
                                            Export
                                            <v-icon color="green">mdi-microsoft-excel</v-icon>
                                        </v-btn>
                </v-toolbar>
            </template>
            <template v-slot:[`item.actions`]="{ item }">
                <v-icon
                    small
                    class="mr-2"
                    @click="detailsItem(item)"
                    color="blue"
                >
                    mdi-information-outline
                </v-icon>
                <v-icon
                    small
                    class="mr-2"
                    @click="editItem(item)"
                    color="yellow"
                >
                    mdi-pencil
                </v-icon>
                <v-icon
                    small
                    @click="deleteItem(item)"
                    color="red"
                >
                    mdi-delete
                </v-icon>
            </template>
        </v-data-table>
    </v-card>
</template>
<script>
export default {
    data: vm => ({
        LMSTab: null,
        dialog: false,
        btnLoader: false,
        dialogDelete: false,
        loadLMS: false,
        detailsReadonly: false,
        genderList : [{value:'Male', text:'Male'}, {value:'Female', text:'Female'}],
        // hideProjArea: true,
        cso_name_items: [],
        status_list: [],
        searchBy: "",
        headers: [
            { text: 'Participant ID', align: 'start', sortable: false, value: 'participant_id', width: '10%' },
            { text: 'Participant Name', align: 'start', sortable: false, value: 'participant_name', width: '25%' },
            { text: 'Location', value: 'participant_location',width: '15%',sortable: false, },
            { text: 'Name of LRO', value: 'cso_name',width: '25%',sortable: false, },
            { text: 'Skills', value: 'participant_skills',width: '15%',sortable: false, },
            { text: 'Actions', value: 'actions',width: '10%',sortable: false, },
        ],
        lmsList: [],
        editedIndex: -1,
        editedItem: {
            participant_id : '',
            participant_name : '',
            participant_location : '',
            participant_address : '',
            participant_position : '',
            lro_id : '',
            participant_gender : '',
            participant_age : '',
            participant_skills : '',
        },
        defaultItem: {
            participant_id : '',
            participant_name : '',
            participant_location : '',
            participant_address : '',
            participant_position : '',
            lro_id : '',
            participant_gender : '',
            participant_age : '',
            participant_skills : '',
        },
        delete_lms: '',
        rules: {
            required: v => !!v || 'This field is required',
            number: v  => {
                if (!isNaN(v)) return true;
                if (!isNaN(v) && v.toString().indexOf('.') != -1) return 'The value entered was not valid.';
                if (!isNaN(parseFloat(v)) && v >= 0) return true;
                return 'The value entered was not valid.';

            },
        }

    }),

    computed: {
        formTitle () {
            return this.editedIndex === -1 ? 'New LMS' : 'Edit LMS'
        },
    },

    watch: {
        dialog (val) {
            val || this.close()
        },
        dialogDelete (val) {
            val || this.closeDelete()
        },

    },

    created () {
        this.initialize()
    },

    methods: {
        initialize () {
            this.loadLMS = true;
            axios.get('/cso-name-list').then(response =>{
                this.cso_name_items = response.data;
            })

            axios.get('/participants-profile').then( response => {
                this.lmsList = response.data;
                this.loadLMS = false;
            })
        },
        detailsItem(item){
            this.detailsReadonly = true;
            this.editedIndex = this.lmsList.indexOf(item);
            this.editedItem = Object.assign({}, item);
            // this.hideProjArea = false;
            this.dialog = true;
        },
        editItem (item) {
            this.editedIndex = this.lmsList.indexOf(item)
            this.editedItem = Object.assign({}, item)
            // this.hideProjArea = true;
            this.dialog = true
        },

        deleteItem (item) {
            this.delete_lms = item.lro_assessment_id
            this.editedIndex = this.lmsList.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        deleteItemConfirm () {
            this.btnLoader = true;
            this.lmsList.splice(this.editedIndex, 1)
            axios.post('/delete-participants-profile', {
                delete_id: this.delete_lms
            }).then(response => {
                if (response.data.success) {
                    this.initialize();
                    this.$noty.success("Successfully deleted.")
                    this.closeDelete()
                }
            })
        },

        close () {
            this.dialog = false;
            this.btnLoader = false;
            this.detailsReadonly = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        closeDelete () {
            this.dialogDelete = false
            this.btnLoader = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        save () {
            this.btnLoader = true;
            let validate = true;
            if(!this.editedItem.participant_name){
                this.$noty.error('Name is empty!');
                validate = false;
            }
            if(!this.editedItem.participant_location){
                this.$noty.error('Location is empty!');
                validate = false;
            }
            if(!this.editedItem.participant_address){
                this.$noty.error('Address is empty!');
                validate = false;
            }
            if(!this.editedItem.participant_position){
                this.$noty.error('Position is empty!');
                validate = false;
            }
            if(!this.editedItem.lro_id){
                this.$noty.error('Name of LRO is empty!');
                validate = false;
            }
            if(!this.editedItem.participant_gender){
                this.$noty.error('Gender is empty!');
                validate = false;
            }
            if(!this.editedItem.participant_age){
                this.$noty.error('Age is empty!');
                validate = false;
            }
            if(!this.editedItem.participant_skills){
                this.$noty.error('Skills is empty!');
                validate = false;
            }
            if(validate){
                axios.post('/save-participants-profile', {
                    data: JSON.stringify(this.editedItem),
                    form_mode: this.editedIndex
                }).then(response => {
                    if (response.data.success) {
                        this.initialize();
                        if (this.editedIndex < 0) {
                            this.$noty.success("Successfully Added.")
                        } else {
                            this.$noty.success("Successfully Updated.")
                        }
                        this.close();
                    }else{
                        this.close();
                    }
                })
            }else{
                this.btnLoader = false;
            }
        },
        exportExcel: function(tableName,value){
            this.btnLoader = true;
            let filename = tableName + '.xlsx';
            var formData = new FormData();
            formData.append('tableName', tableName);
            formData.append('category', value);
            axios.post('/export-excel', formData, {responseType: 'blob'}).then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', filename);
                document.body.appendChild(link);
                link.click();
                this.btnLoader = false;
            });

        }
    },

}
</script>
