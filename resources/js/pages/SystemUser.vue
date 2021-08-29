<template>
    <v-app>
        <h3 class="subheading grey--text">System Users</h3>
                
        <v-data-table :headers="headers" :items="usersList" :search="searchBy" class="elevation-1" >
            
            <template v-slot:top>

                <v-toolbar flat >
                    <v-text-field  v-model="searchBy" append-icon="mdi-magnify" label="Search" single-line hide-details ></v-text-field>
                    <v-spacer></v-spacer>
                    
                    <v-dialog v-model="dialog" max-width="500px" >
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn color="lightgray" class="mb-2" v-bind="attrs" v-on="on" >
                                New Account
                            </v-btn>
                        </template>
                        <v-card>
                            <v-card-title>
                                <span class="text-h5">{{ formTitle }}</span>
                            </v-card-title>
                            <v-card-text >
                                <v-container dense>
                                    <v-row>
                                        <v-col cols="12" mr='2'>
                                            <v-text-field v-model="editedItem.firstname" label="First name" ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" mr='2' >
                                            <v-text-field v-model="editedItem.lastname" label="Last name" ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" mr='2'>
                                            <v-text-field v-model="editedItem.email" type="email" label="email"></v-text-field>
                                        </v-col>
                                        <v-col cols="12" mr='2'>
                                            <v-row class="mt-0" v-if="!detailsReadonly">
                                                <v-col cols="12" sm="12" md="12"  >
                                                    <v-select v-if="roles"
                                                        :items="roles"
                                                        :item-text="'name'"
                                                        :item-value="'id'"
                                                        v-model="editedItem.role_id"
                                                        name="id"
                                                        label="Account Role *" dense
                                                        :rules="[rules.required]"
                                                    ></v-select>
                                                </v-col>
                                            </v-row>
                                            <v-row class="mt-0" v-if="detailsReadonly">
                                                <v-col cols="12" sm="12" md="12"  >
                                                    <v-text-field v-model="editedItem.cso_name" label="Account Role *" dense readonly></v-text-field>
                                                </v-col>
                                            </v-row>
                                        </v-col>


                                        <v-col cols="12" mr='2'>
                                            <v-text-field v-model="editedItem.password" type="password" label="password" ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" mr='2'>
                                            <v-text-field v-model="editedItem.confirm_password" type="password" label="confirm_password" ></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-text>

                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="close"> Cancel </v-btn>
                                <v-btn color="blue darken-1" text @click="save"> Save </v-btn>
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
                <v-icon @click="editItem(item)" small class="mr-2" color="blue darken-2" > mdi-pencil </v-icon>
                <v-icon @click="deleteItem(item)" small color="red" > mdi-delete </v-icon>
            </template>
        </v-data-table>
    </v-app>
</template>
<script>
export default {
    data: () => ({
         
        dialog: false,
        dialogDelete: false,
        detailsReadonly: false,
        searchBy:"",
        expanded: [],
        roles: [],
        singleExpand: false,
        headers: [
            { text: 'First Name', align: 'start', sortable: false, value: 'firstname', width: '15%' },
            { text: 'Last Name', align: 'start', sortable: false, value: 'lastname' },
            { text: 'Email', value: 'email',width: '10%',sortable: false, },
            { text: 'Role', value: 'role',width: '10%',sortable: false, },
            { text: 'Actions', value: 'actions',width: '10%',sortable: false, },
        ],
        usersList: [],
        editedIndex: -1,
        editedItem: {
            firstname: '',
            lastname: '',
            email: '',
            role_id: '',
            password:'',
            confirm_password:'',

        },
        defaultItem: {
            firstname: '',
            lastname: '',
            email: '',
            role_id: '',
            password:'',
            confirm_password:'',
        },
        rules: {
            required: v => !!v || 'This field is required',
            number: v  => {
                if (!isNaN(v)) return true;
                if (!isNaN(v) && v.toString().indexOf('.') != -1) return 'The value entered was not valid.';
                if (!isNaN(parseFloat(v)) && v >= 0) return true;
                return 'The value entered was not valid.';

            },
        },
    }),

    computed: {
        formTitle () {
            return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
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
            document.title = "CSO | System User"
            axios.get('/user-roles').then( response => {
                this.roles =  response.data ;
            })
            axios.get('/system-users').then( response => {
                this.usersList = response.data;
            })
        },
        
        editItem(item) {
            this.editedIndex = this.usersList.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
            console.log(item);
        },

        deleteItem (item) {
            // this.editedIndex = this.desserts.indexOf(item)
            // this.editedItem = Object.assign({}, item)
            // this.dialogDelete = true
        },

        deleteItemConfirm () {
            // this.desserts.splice(this.editedIndex, 1)
            // this.closeDelete()
        },

        close () {
            this.dialog = false;
            this.detailsReadonly = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        closeDelete () {
            this.detailsReadonly = false;
            this.dialogDelete = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        validateEmail(email) {
            const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        },

        save () {
            let validate = true;
            if(!this.editedItem.firstname){
                this.$noty.error('First Name is empty!');
                validate = false;
            }
            if(!this.editedItem.lastname){
                this.$noty.error('Last Name is empty!');
                validate = false;
            }
            if(!this.editedItem.email){
                this.$noty.error('Email is empty!');
                validate = false;
            }
            if( !this.validateEmail(this.editedItem.email) ){
                this.$noty.error('Email is not valid!');
                validate = false;
            }

            if(!this.editedItem.password || this.editedItem.password.length < 8){
                this.$noty.error('password should be minimum 8 characters !');
                validate = false;        
            }
            if(!this.editedItem.confirm_password){
                this.$noty.error('confirm password can\'t be empty !');
                validate = false;        
            }
            
            if(this.editedItem.confirm_password != this.editedItem.password){
                this.$noty.error('Password and confirm password should be same ');
                validate = false;        
            }
            if(!this.editedItem.role_id){
                this.$noty.error('The Role of the Account should not be empty')
                validate = false;
            }

            this.editedItem['id_exist'] =  this.editedItem.hasOwnProperty("id")
            if(validate){
                var formData = new FormData();
                formData.append( 'data', JSON.stringify(this.editedItem) );
                axios.post('/save-user', formData ).then(response => {
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
        getColor (status) {

            if (status == 'delay') return 'red'
            else if (status == 'progess') return 'blue'
            else if (status == 'entry') return 'orange'
            else return 'green'
        },

        getValue(value){

            return value;
        }
    },
}
</script>
