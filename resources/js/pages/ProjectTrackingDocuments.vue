<template>
    <v-app>
        <h3 class="subheading grey--text">Project Tracking Document</h3>
        <br>
        <v-card>
            <v-data-table
                :headers="headers"
                :items="documentList"
                :search="searchBy"
                :loading="loadDocument"
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
                                    <span class="text-h5" v-else>Project Tracking Document Details</span>
                                </v-card-title>

                                <v-card-text>
                                    <v-container dense >
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12" >
                                                <v-text-field :readonly="detailsReadonly"
                                                              :rules="[rules.required]"
                                                              v-model="editedItem.document_name" label="Document Name *" dense></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0" v-if="!detailsReadonly">
                                            <v-col cols="12" sm="12" md="12"  >
                                                <v-select
                                                    :items="document_type_items"
                                                    v-model="editedItem.document_type"
                                                    :rules="[rules.required]"
                                                    label="Document Type *" dense
                                                ></v-select>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0" v-if="detailsReadonly">
                                            <v-col cols="12" sm="12" md="12"  >
                                                <v-text-field v-model="editedItem.document_type"
                                                              :rules="[rules.required]"
                                                              label="Document Type *" dense readonly></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-textarea :readonly="detailsReadonly" auto-grow rows="1"
                                                            :rules="[rules.required]"
                                                            v-model="editedItem.document_description" label="Description *" dense></v-textarea>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12" >
                                                <v-text-field :readonly="detailsReadonly"
                                                              :rules="[rules.required]"
                                                              v-model="editedItem.document_version" label="Version *" dense></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field :readonly="detailsReadonly"
                                                              :rules="[rules.required]"
                                                              v-model="editedItem.document_source" label="Source *" dense></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0" v-if="!detailsReadonly">
                                            <v-col cols="12" sm="12" md="12"  >
                                                <v-select
                                                    :items="document_owner_items"
                                                    v-model="editedItem.document_owner"
                                                    label="Document Owner *" dense
                                                    :rules="[rules.required]"
                                                ></v-select>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0" v-if="detailsReadonly">
                                            <v-col cols="12" sm="12" md="12"  >
                                                <v-text-field v-model="editedItem.document_owner"
                                                              label="Document Owner" dense readonly></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0">
                                            <v-col cols="12" sm="12" md="12" >
                                                <v-text-field :readonly="detailsReadonly"
                                                              v-model="editedItem.document_remarks" label="Remarks" dense></v-text-field>
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
                                                        Upload Document
                                                    </v-btn>
                                                    <input ref="uploader" class="d-none" type="file" @change="onFileChanged" >
                                                </div>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mt-0" v-if="detailsReadonly">
                                            <v-col cols="12" sm="12" md="12"  >
                                                <v-text-field v-model="editedItem.document_date"
                                                              label="Date Uploaded" dense readonly></v-text-field>
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
                                    <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                                    <v-spacer></v-spacer>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
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
    </v-app>
</template>
<script>
export default {
    data: vm => ({
        dialog: false,
        btnLoader: false,
        dialogDelete: false,
        loadDocument: false,
        detailsReadonly: false,
        modelAssessmentDate: false,
        // hideProjArea: true,
        document_type_items: [],
        document_owner_items: [],
        searchBy: "",
        headers: [
            { text: 'Name', align: 'start', sortable: false, value: 'document_name', width: '15%' },
            { text: 'Type', align: 'start', sortable: false, value: 'document_type', width: '10%' },
            { text: 'Description', align: 'start', sortable: false, value: 'document_description', width: '15%' },
            { text: 'Version', align: 'start', sortable: false, value: 'document_version', width: '8%' },
            { text: 'Source', value: 'document_source',width: '10%',sortable: false, },
            { text: 'Owner', value: 'document_owner',width: '10%',sortable: false, },
            { text: 'Remarks', value: 'document_remarks',width: '12%',sortable: false, },
            { text: 'Date Uploaded', value: 'document_date',width: '10%',sortable: false, },
            { text: 'Actions', value: 'actions',width: '10%',sortable: false, },
        ],
        documentList: [],
        editedIndex: -1,
        editedItem: {
            document_name : '' ,
            document_type : '' ,
            document_description : '' ,
            document_version : '' ,
            document_date : '' ,
            document_source : '' ,
            document_owner : '' ,
            document_file_size : '' ,
            document_remarks : '' ,
        },
        defaultItem: {
            document_name : '' ,
            document_type : '' ,
            document_description : '' ,
            document_version : '' ,
            document_date : '' ,
            document_source : '' ,
            document_owner : '' ,
            document_file_size : '' ,
            document_remarks : '' ,
        },
        delete_document: '',
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

    }),

    computed: {
        formTitle () {
            return this.editedIndex === -1 ? 'New Project Tracking Document' : 'Edit Project Tracking Document'
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
            this.loadDocument = true;
            axios.get('/document-type').then(response =>{
                this.document_type_items = response.data;
            })

            axios.get('/document-owner').then(response =>{
                this.document_owner_items = response.data;
            })

            axios.get('/document').then( response => {
                this.documentList = response.data;
                this.loadDocument = false;
            })
        },
        detailsItem(item){
            this.detailsReadonly = true;
            this.editedIndex = this.documentList.indexOf(item);
            this.editedItem = Object.assign({}, item);
            // this.hideProjArea = false;
            this.dialog = true;
        },
        editItem (item) {
            this.editedIndex = this.documentList.indexOf(item)
            this.editedItem = Object.assign({}, item)
            // this.hideProjArea = true;
            this.dialog = true
        },

        deleteItem (item) {
            this.delete_document = item.document_id
            this.editedIndex = this.documentList.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        deleteItemConfirm () {
            this.documentList.splice(this.editedIndex, 1)
            axios.post('/delete-document', {
                delete_id: this.delete_document
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
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        save () {
            this.btnLoader = true;
            let validate = true;
            if(!this.editedItem.document_name){
                this.$noty.error('Document Name is empty!');
                validate = false;
            }
            if(!this.editedItem.document_type){
                this.$noty.error('Document Type is empty!');
                validate = false;
            }
            if(!this.editedItem.document_description){
                this.$noty.error('Description is empty!');
                validate = false;
            }
            if(!this.editedItem.document_version){
                this.$noty.error('Version is empty!');
                validate = false;
            }
            if(!this.editedItem.document_source){
                this.$noty.error('Source is empty!');
                validate = false;
            }
            if(!this.editedItem.document_owner){
                this.$noty.error('Document Owner is empty!');
                validate = false;
            }
            if(!this.file_name){
                this.$noty.error('No file uploaded!');
                validate = false;
            }
            if(validate){ 
                var formData = new FormData();
                formData.append('data', JSON.stringify(this.editedItem));
                formData.append('form_mode', this.editedIndex);
                formData.append('upload_file', this.file_attached);
                formData.append('file_name', this.file_name);
                axios.post('/save-document', formData).then(response => {
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
        onButtonClick: function() {
            this.isSelecting = true
            window.addEventListener('focus', () => {
                this.isSelecting = false
            }, { once: true })

            this.$refs.uploader.click()
        },
        onFileChanged: function(e) {
            var files = e.target.files || e.dataTransfer.files;

            if (files.length && files[0].type == 'application/pdf' ){
                this.file_attached = files[0];
                this.file_name = files[0].name;
                this.isRemove = true;
            }
            else{
                this.$noty.error('Invalid file type. Please upload only pdf file.');
            }
        },
        removeFile: function (item) {
            this.file_name = "";
            this.isRemove = false;
            this.file_attached = "";
        },
    },

}
</script>
