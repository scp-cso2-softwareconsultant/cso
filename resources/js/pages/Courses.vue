<template>
    <v-card>
        <v-data-table
            :headers="headers"
            :items="courseList"
            :search="searchBy"
            :loading="loadCourse"
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
                                <span class="text-h5" v-else>Course Details</span>
                            </v-card-title>

                            <v-card-text>
                                <v-container dense >
                                    <v-row class="mt-0">
                                        <v-col cols="12" sm="12" md="12" >
                                            <v-text-field :readonly="detailsReadonly"
                                                          :rules="[rules.required]"
                                                          v-model="editedItem.course_name" label="Course Name *" dense></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field :readonly="detailsReadonly"
                                                          :rules="[rules.required]"
                                                          v-model="editedItem.project_area" label="Project Area *" dense></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0">
                                        <v-col cols="12" sm="12" md="12" >
                                            <v-text-field :readonly="detailsReadonly"
                                                          :rules="[rules.required, rules.number]"
                                                          v-model="editedItem.number_of_modules" label="Number of modules *" dense></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0">
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field :readonly="detailsReadonly"
                                                          :rules="[rules.required]"
                                                          v-model="editedItem.developed_by" label="Developed By *" dense></v-text-field>
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
                                               @click="exportExcel('Courses','')" >
                                            Export
                                            <v-icon color="green">mdi-microsoft-excel</v-icon>
                                        </v-btn>
                </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
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
        dialog: false,
        btnLoader: false,
        dialogDelete: false,
        loadCourse: false,
        detailsReadonly: false,
        searchBy: "",
        headers: [
            { text: 'ID', align: 'start', sortable: false, value: 'course_id', width: '10%' },
            { text: 'Course Name', align: 'start', sortable: false, value: 'course_name', width: '25%' },
            { text: 'Project Area', align: 'start', sortable: false, value: 'project_area', width: '20%' },
            { text: 'Number of Modules', value: 'number_of_modules',width: '15%',sortable: false, align: 'right'},
            { text: 'Developed By', value: 'developed_by',width: '20%',sortable: false, },
            { text: 'Actions', value: 'actions',width: '10%',sortable: false, },
        ],
        courseList: [],
        editedIndex: -1,
        editedItem: {
            course_name : '',
            project_area : '',
            number_of_modules : 0,
            developed_by : '',
        },
        defaultItem: {
            course_name : '',
            project_area : '',
            number_of_modules : 0,
            developed_by : '',
        },
        delete_courses: '',
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
            return this.editedIndex === -1 ? 'New Course' : 'Edit Course'
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
            this.loadCourse = true;
            axios.get('/courses').then( response => {
                this.courseList = response.data;
                this.loadCourse = false;
            })
        },
        detailsItem(item){
            this.detailsReadonly = true;
            this.editedIndex = this.courseList.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
        },
        editItem (item) {
            this.editedIndex = this.courseList.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem (item) {
            this.delete_courses = item.course_id
            this.editedIndex = this.courseList.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        deleteItemConfirm () {
            this.btnLoader = true;
            this.courseList.splice(this.editedIndex, 1)
            axios.post('/delete-courses', {
                delete_id: this.delete_courses
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
            this.dialogDelete = false;
            this.btnLoader = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        save () {
            this.btnLoader = true;
            let validate = true;
            if(!this.editedItem.course_name){
                this.$noty.error('Course Name is empty!');
                validate = false;
            }
            if(!this.editedItem.project_area){
                this.$noty.error('Project Area is empty!');
                validate = false;
            }
            if(!this.editedItem.number_of_modules){
                this.$noty.error('Number of modules is empty!');
                validate = false;
            }
            if(!this.editedItem.developed_by){
                this.$noty.error('Developed By is empty!');
                validate = false;
            }

            if(validate){
                axios.post('/save-courses', {
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
        exportExcel: function(tableName, value){
            this.btnLoader = true;
            let filename = tableName + '.xlsx';
            var formData = new FormData();
            formData.append('tableName', tableName);
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
