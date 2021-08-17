<template>
    <v-app>
        <h3 class="subheading grey--text">Assessment</h3>
        <br>
        <v-card>
            <v-data-table
                :headers="headers"
                :items="lroList"
                :single-expand="singleExpand"
                :expanded.sync="expanded"
                :search="searchBy"
                item-key="lro_assessment_id"
                :loading="loadLROAssessment"
                show-expand
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
                                    <span class="text-h5" v-else>Assessment Details</span>
                                </v-card-title>

                                <v-card-text>
                                    <v-container dense >
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
                                                <v-text-field v-model="editedItem.cso_name" label="Name of LRO *" dense readonly></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0" v-if="detailsReadonly">
                                            <v-col cols="12" sm="12" md="12" >
                                                <v-text-field v-model="editedItem.proj_area" label="Project Area" dense readonly></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0" v-if="editedIndex != -1 && !detailsReadonly">
                                            <v-col cols="12" sm="12" md="12"  >
                                                <v-select
                                                    :items="status_list"
                                                    v-model="editedItem.status"
                                                    label="Status" dense
                                                ></v-select>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0" v-if="detailsReadonly">
                                            <v-col cols="12" sm="12" md="12" >
                                                <v-text-field v-model="editedItem.status" label="Status" dense readonly></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12" >
                                                <v-text-field v-model="editedItem.domain"
                                                              :readonly="detailsReadonly"
                                                              :rules="[rules.required]"
                                                              label="Domain *" dense></v-text-field>
                                            </v-col>
                                        </v-row>

                                        <v-row class="mt-0" v-if="!detailsReadonly">
                                            <v-col cols="12" sm="12" md="12"  >
                                                <v-select
                                                    :items="tool_list"
                                                    v-model="editedItem.tool_used"
                                                    label="Tool Used *" dense
                                                    :rules="[rules.required]"
                                                ></v-select>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0" v-if="detailsReadonly">
                                            <v-col cols="12" sm="12" md="12"  >
                                                <v-text-field v-model="editedItem.tool_used" label="Tool Used *" dense readonly></v-text-field>
                                            </v-col>
                                        </v-row>

                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12" >
                                                <v-text-field :readonly="detailsReadonly"
                                                              v-model="editedItem.final_score" label="Final Score" dense></v-text-field>
                                            </v-col>
                                        </v-row>

                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12" >
                                                <v-text-field :readonly="detailsReadonly"
                                                              v-model="editedItem.conducted_by" label="Conducted By" dense></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0" v-if="!detailsReadonly">
                                            <v-col cols="12" sm="12" md="12" >
                                                <v-menu
                                                    ref="modelAssessmentDate"
                                                    v-model="modelAssessmentDate"
                                                    :close-on-content-click="false"
                                                    transition="scale-transition"
                                                    offset-y
                                                    max-width="290px"
                                                    min-width="auto"
                                                    dense
                                                >
                                                    <template v-slot:activator="{ on, attrs }">
                                                        <v-text-field
                                                            v-model="editedItem.assessment_date"
                                                            label="Assessment Date"
                                                            persistent-hint
                                                            append-outer-icon="mdi-calendar"
                                                            v-bind="attrs"
                                                            v-on="on"
                                                            dense
                                                        ></v-text-field>
                                                    </template>
                                                    <v-date-picker
                                                        v-model="editedItem.assessment_date"
                                                        no-title
                                                        @input="modelAssessmentDate = false"
                                                        dense
                                                    ></v-date-picker>
                                                </v-menu>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0" v-if="detailsReadonly">
                                            <v-col cols="12" sm="12" md="12" >
                                                <v-text-field v-model="editedItem.assessment_date" label="Assessment Date" dense readonly></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12" >
                                                <div v-if="isRemove">
                                                    <v-btn text small color="blue darken-1" >
                                                        {{ file_name }}
                                                    </v-btn>
                                                    <v-btn background depressed @click="removeFile"  dense small>
                                                        <v-icon color="red darken-1">mdi-close-thick</v-icon>
                                                    </v-btn>
                                                </div>
                                                <div v-else>
                                                    <v-btn text small :loading="isSelecting" color="blue darken-1" @click="onButtonClick" >
                                                        Upload MOV
                                                    </v-btn>
                                                    <input ref="uploader" class="d-none" type="file" @change="onFileChanged" >
                                                </div>
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
                        <v-dialog
                            v-model="subdialog"
                            max-width="500px"
                        >
                            <v-card>
                                <v-card-title>
                                    <span class="text-h5">{{ formSubTitle }}</span>
                                </v-card-title>

                                <v-card-text>
                                    <v-container dense>
                                        <v-row class="mt-0" >
                                            <v-col cols="12" sm="12" md="12" >
                                                <v-text-field v-model="editedSubItem.sub_domain"
                                                              :rules="[rules.required]"
                                                              :readonly="detailsReadonly"
                                                              label="Sub Domain *" dense ></v-text-field>
                                            </v-col>
                                        </v-row>

                                        <v-row class="mt-0" v-if="!detailsReadonly">
                                            <v-col cols="12" sm="12" md="12" >
                                                <v-select
                                                    :items="rating_list"
                                                    v-model="editedSubItem.rating"
                                                    label="Rating *" dense
                                                    :rules="[rules.required]"
                                                ></v-select>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0" v-if="detailsReadonly">
                                            <v-col cols="12" sm="12" md="12" >
                                                <v-text-field v-model="editedSubItem.rating"
                                                              label="Rating *" dense readonly></v-text-field>
                                            </v-col>
                                        </v-row>

                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12" >
                                                <v-textarea auto-grow rows="1"
                                                            :readonly="detailsReadonly"
                                                            v-model="editedSubItem.remarks" label="Remarks" dense ></v-textarea>
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                </v-card-text>
                                <v-card-actions v-if="!detailsReadonly">
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        color="blue darken-1"
                                        text
                                        @click="closeSub"
                                        dense
                                    >
                                        Cancel
                                    </v-btn>
                                    <v-btn
                                        color="blue darken-1"
                                        text
                                        @click="saveSub"
                                        dense
                                        :loading="btnLoader"
                                    >
                                        Save
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-toolbar>
                </template>
                <template v-slot:item.mov="{ item }">
                    <div v-if="item.mov">
                        <v-btn text color="primary"
                               @click="downloadFile(item.mov)">
                            {{ item.file_name_old }}
                            <v-icon center color="primary">
                                mdi-file-download-outline
                            </v-icon>
                        </v-btn>
                    </div>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="addSubItem(item)"
                        color="green"
                    >
                        mdi-sticker-plus-outline
                    </v-icon>
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
                <template v-slot:expanded-item="{ headers, item }">
                    <td :colspan="headers.length">
                        <v-data-table
                            :headers="subHeaders"
                            :items="item.subItems"
                            class="elevation-1"
                        >
                            <template v-slot:item.actions="{ item }">
                                <v-icon
                                    small
                                    class="mr-2"
                                    @click="editSubItem(item)"
                                    color="yellow"
                                >
                                    mdi-pencil
                                </v-icon>
                                <v-icon
                                    small
                                    @click="deleteSubItem(item)"
                                    color="red"
                                >
                                    mdi-delete
                                </v-icon>
                            </template>
                        </v-data-table>
                    </td>
                </template>
            </v-data-table>
        </v-card>
    </v-app>
</template>
<script>
export default {
    data: vm => ({
        dialog: false,
        btnLoader: false,
        dialogDelete: false,
        loadLROAssessment: false,
        detailsReadonly: false,
        modelAssessmentDate: false,
        // hideProjArea: true,
        cso_name_items: [],
        status_list: [],
        expanded: [],
        tool_list: ['OCAT','OPI'],
        singleExpand: false,
        searchBy: "",
        headers: [
            { text: 'Name of LRO', align: 'start', sortable: false, value: 'cso_name', width: '15%' },
            { text: 'Domain', value: 'domain',width: '15%',sortable: false},
            { text: 'Tool Used', value: 'tool_used',width: '10%',sortable: false, },
            { text: 'Conducted By', value: 'conducted_by',width: '15%',sortable: false, },
            { text: 'Date of Assessment', value: 'assessment_date',width: '12%',sortable: false, },
            { text: 'Final Score', value: 'final_score',width: '10%',sortable: false, align: 'right' },
            { text: 'MOV', value: 'mov',width: '3%',sortable: false, align: 'center'},
            { text: 'Status', value: 'status',width: '10%',sortable: false, },
            { text: 'Actions', value: 'actions',width: '10%',sortable: false, },
            { text: '', value: 'data-table-expand' },
        ],
        subHeaders: [
            { text: 'Sub Domain', align: 'start', sortable: false, value: 'sub_domain', width: '25%' },
            { text: 'Rating', value: 'rating',width: '15%',sortable: false},
            { text: 'Remarks', value: 'remarks',sortable: false, },
            { text: 'Actions', value: 'actions',width: '10%',sortable: false, },
        ],
        lroList: [],
        editedIndex: -1,
        editedItem: {
            lro_id: '',
            proj_area: '',
            domain: '',
            tool_used: '',
            conducted_by: '',
            assessment_date: '',
            final_score: '',
            mov: '',
            status: '',

        },
        defaultItem: {
            lro_id: '',
            proj_area: '',
            domain: '',
            tool_used: '',
            conducted_by: '',
            assessment_date: '',
            final_score: '',
            mov: '',
            status: '',
        },
        editedSubItem: {
            lro_assessment_id: '',
            sub_domain: '',
            rating: '',
            remarks: '',
        },
        defaultSubItem: {
            lro_assessment_id: '',
            sub_domain: '',
            rating: '',
            remarks: '',
        },
        delete_lro: '',
        rules: {
            required: v => !!v || 'This field is required',
            number: v  => {
                if (!isNaN(v)) return true;
                if (!isNaN(v) && v.toString().indexOf('.') != -1) return 'The value entered was not valid.';
                if (!isNaN(parseFloat(v)) && v >= 0) return true;
                return 'The value entered was not valid.';

            },
        },
        isRemove:false,
        isSelecting: false,
        file_name: "",
        file_attached: "",
        assessment_id: "",
        formSubTitle: '',
        subdialog: false,
        delete_lro_sub: '',
        rating_list:[],
    }),

    computed: {
        formTitle () {
            return this.editedIndex === -1 ? 'New Assessment' : 'Edit Assessment'
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
            this.loadLROAssessment = true;
            axios.get('/cso-name-list').then(response =>{
                this.cso_name_items = response.data;
            })

            axios.get('/lro-status').then(response =>{
                this.status_list = response.data;
            })

            axios.get('/lro-assessment').then( response => {
                this.lroList = response.data;
                this.loadLROAssessment = false;
            })
        },
        detailsItem(item){
            this.detailsReadonly = true;
            this.editedIndex = this.lroList.indexOf(item);
            this.editedItem = Object.assign({}, item);
            // this.hideProjArea = false;
            this.dialog = true;
        },
        editItem (item) {
            this.editedIndex = this.lroList.indexOf(item)
            this.editedItem = Object.assign({}, item)
            // this.hideProjArea = true;
            this.dialog = true
        },

        deleteItem (item) {
            this.delete_lro = item.lro_assessment_id
            this.editedIndex = this.lroList.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },


        addSubItem(item){
            this.rating_list = item.rating_tool;
            this.assessment_id = item.lro_assessment_id;
            this.formSubTitle = 'New Sub Domain';
            this.editedSubItem = Object.assign({}, item)
            this.subdialog = true
        },

        detailsSubItem(item){
            this.formSubTitle = 'Sub Domain Details';
            this.editedSubItem = Object.assign({}, item)
            this.detailsReadonly = true;
            this.subdialog = true
        },

        editSubItem (item) {
            this.editedIndex = 1;
            this.formSubTitle = 'Edit Sub Domain';
            this.editedSubItem = Object.assign({}, item)
            this.subdialog = true
        },

        deleteSubItem (item) {
            this.delete_lro_sub = item.lro_sub_id;
            this.dialogDelete = true
        },


        deleteItemConfirm () {
            this.btnLoader = true;
            this.lroList.splice(this.editedIndex, 1)

            if(this.delete_lro) {
                axios.post('/delete-lro-assessment', {
                    delete_id: this.delete_lro
                }).then(response => {
                    if (response.data.success) {
                        this.initialize();
                        this.$noty.success("Successfully deleted.")
                        this.closeDelete()
                    }
                })
            }

            if(this.delete_lro_sub){
                axios.post('/delete-lro-sub-assessment', {
                    delete_id: this.delete_lro_sub
                }).then(response => {
                    if (response.data.success) {
                        this.initialize();
                        this.$noty.success("Successfully deleted.")
                        this.closeDelete()
                    }
                })
            }
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

        closeSub () {
            this.assessment_id = '';
            this.detailsReadonly = false;
            this.btnLoader = false;
            this.editedIndex = -1
            this.subdialog = false
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
            if(!this.editedItem.lro_id){
                this.$noty.error('Name of LRO is empty!');
                validate = false;
            }
            if(!this.editedItem.domain){
                this.$noty.error('Domain is empty!');
                validate = false;
            }
            if(!this.editedItem.tool_used){
                this.$noty.error('Tool Used is empty!');
                validate = false;
            }
            if(validate){
                var formData = new FormData();
                formData.append('data', JSON.stringify(this.editedItem));
                formData.append('form_mode', this.editedIndex);
                formData.append('upload_file', this.file_attached);
                formData.append('file_name', this.file_name);
                axios.post('/save-lro-assessment', formData).then(response => {
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

        saveSub () {
            this.btnLoader = true;
            let validate = true;
            if(!this.editedSubItem.sub_domain){
                this.$noty.error('Sub Domain is empty!');
                validate = false;
            }
            if(!this.editedSubItem.rating){
                this.$noty.error('Rating is empty!');
                validate = false;
            }

            if(validate){
                var formData = new FormData();
                formData.append('data', JSON.stringify(this.editedSubItem));
                formData.append('form_mode', this.editedIndex);
                formData.append('lro_assessment_id', this.assessment_id);
                axios.post('/save-lro-sub-assessment',formData).then( response => {
                    if(response.data.success){
                        this.initialize();
                        if(this.editedIndex < 0) {
                            this.$noty.success("Successfully Added.")
                        }else{
                            this.$noty.success("Successfully Updated.")
                        }
                        this.closeSub();
                    }else{
                        this.closeSub();
                    }
                })
            }else{
                this.btnLoader = false;
            }
        },


        onButtonClick: function() {
            this.isSelecting = true
            window.addEventListener('focus', () => {
                this.isSelecting = false
            }, { once: true })

            this.$refs.uploader.click()
        },
        onFileChanged: function(e) {
            var files = e.target.files || e.dataTransfer.files;

            // if (files.length && files[0].type == 'application/pdf' ){
                this.file_attached = files[0];
                this.file_name = files[0].name;
                this.isRemove = true;
            // }
            // else{
            //     this.$noty.error('Invalid file type. Please upload only pdf file.');
            // }
        },
        removeFile: function (item) {
            this.file_name = "";
            this.isRemove = false;
            this.file_attached = "";
        },
        downloadFile: function(encoded_url){
            window.open("download/"+encoded_url);
        },


    },

}
</script>
