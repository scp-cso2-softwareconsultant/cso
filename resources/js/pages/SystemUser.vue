<template>
    <v-app>
        <h3 class="subheading grey--text">System Users</h3>

        <v-data-table :headers="headers" :items="usersList"
            :search="filters.filter_items[filters.filter_items_active].value" :custom-filter="filterItems"
            class="elevation-1">
            <template v-slot:top>
                <v-toolbar flat>
                    <v-spacer></v-spacer>
                    <v-dialog v-model="dialog" max-width="500px">
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn v-show="crud_guard.create" color="lightgray" class="mb-2" v-bind="attrs" v-on="on">
                                New Account
                            </v-btn>
                        </template>
                        <v-card>
                            <v-card-title class="text-h5 font-weight-regular blue-grey darken-3 white--text">
                                <span class="text-h5">{{ formTitle }}</span>
                            </v-card-title>
                            <v-card-text>
                                <v-container dense>
                                    <v-row>
                                        <v-col cols="12" mr="2">
                                            <v-text-field v-model="editedItem.firstname" label="First name">
                                            </v-text-field>
                                        </v-col>
                                        <v-col cols="12" mr="2">
                                            <v-text-field v-model="editedItem.lastname" label="Last name">
                                            </v-text-field>
                                        </v-col>
                                        <v-col cols="12" mr="2">
                                            <v-text-field v-model="editedItem.email" type="email" label="email">
                                            </v-text-field>
                                        </v-col>
                                        <v-col cols="12" mr="2">
                                            <v-row class="mt-0" v-if="!detailsReadonly">
                                                <v-col cols="12" sm="12" md="12">
                                                    <v-select v-if="roles" :items="roles" :item-text="'name'"
                                                        :item-value="'id'" v-model="editedItem.roles_id" name="id"
                                                        label="Account Role *" dense :rules="[rules.required]">
                                                    </v-select>
                                                </v-col>
                                            </v-row>
                                            <v-row class="mt-0" v-if="detailsReadonly">
                                                <v-col cols="12" sm="12" md="12">
                                                    <v-text-field v-model="editedItem.cso_name" label="Account Role *"
                                                        dense readonly></v-text-field>
                                                </v-col>
                                            </v-row>
                                        </v-col>

                                        <v-col cols="12" mr="2">
                                            <v-text-field v-model="editedItem.password" type="password"
                                                label="password"></v-text-field>
                                        </v-col>
                                        <v-col cols="12" mr="2">
                                            <v-text-field v-model="editedItem.confirm_password" type="password"
                                                label="confirm_password"></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-text>

                            <v-card-actions class=" blue-grey darken-3 white--text">
                                <v-spacer></v-spacer>
                                <v-btn color="blue lighten-5" text @click="close">
                                    Cancel
                                </v-btn>
                                <v-btn color="blue lighten-5" text @click="save"> Save </v-btn>
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
                                <v-btn color="blue lighten-5" text @click="deleteItemConfirm">Yes
                                </v-btn>
                                <v-spacer></v-spacer>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-toolbar>
                <v-row no-gutters style="flex-wrap: nowrap">
                    <v-col cols="8" class="flex-grow-0 flex-shrink-0">
                        <v-text-field v-model="filters.filter_items['firstname'].value"
                            :label="filters.filter_items['firstname'].text"
                            @input="changeFilterActiveValue('firstname')" append-icon="mdi-magnify" outlined
                            hide-details></v-text-field>
                    </v-col>
                    <v-col cols="4" class="flex-grow-0 flex-shrink-0">
                        <v-text-field v-model="filters.filter_items['lastname'].value"
                            :label="filters.filter_items['lastname'].text" @input="changeFilterActiveValue('lastname')"
                            append-icon="mdi-magnify" outlined hide-details></v-text-field>
                    </v-col>
                </v-row>
                <v-row no-gutters style="flex-wrap: nowrap" class="my-3">
                    <v-col cols="8">
                        <v-text-field v-model="filters.filter_items['email'].value"
                            :label="filters.filter_items['email'].text" @input="changeFilterActiveValue('email')"
                            append-icon="mdi-magnify" outlined hide-details></v-text-field>
                    </v-col>
                    <v-col cols="4" class="flex-grow-0 flex-shrink-0">
                        <v-select v-model="filters.filter_items['role'].value"
                            :label="filters.filter_items['role'].text"
                            :items="filters.filter_items['role'].multiple_selection"
                            @input="changeFilterActiveValue('role')" outlined hide-details></v-select>
                    </v-col>
                </v-row>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-icon v-show="crud_guard.update" @click="editItem(item)" small class="mr-2" color="blue darken-2">
                    mdi-pencil
                </v-icon>
                <v-icon v-show="crud_guard.delete" @click="deleteItem(item)" small color="red">
                    mdi-delete
                </v-icon>
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
            searchBy: "",
            expanded: [],
            roles: [],
            singleExpand: false,
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

            filters: {
                filter_items_active: "firstname",
                filter_items: {
                    firstname: {
                        value: "",
                        text: "First Name",
                        data_value: "firstname",
                    },
                    lastname: {
                        value: "",
                        text: "Last Name",
                        data_value: "lastname",
                    },
                    email: {
                        value: "",
                        text: "Email",
                        data_value: "email",
                    },
                    role: {
                        value: "",
                        text: "Role",
                        data_value: "role",
                        multiple_selection: [{
                            text: "None",
                            value: ""
                        }],
                    },
                },
            },
            headers: [{
                    text: "First Name",
                    align: "start",
                    sortable: false,
                    value: "firstname",
                    width: "15%",
                },
                {
                    text: "Last Name",
                    align: "start",
                    sortable: false,
                    value: "lastname",
                    width: "15%",
                },
                {
                    text: "Email",
                    value: "email",
                    width: "10%",
                    sortable: false
                },
                {
                    text: "Role",
                    value: "role",
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
            usersList: [],
            editedIndex: -1,
            editedItem: {
                firstname: "",
                lastname: "",
                email: "",
                roles_id: "",
                password: "",
                confirm_password: "",
            },
            defaultItem: {
                firstname: "",
                lastname: "",
                email: "",
                roles_id: "",
                password: "",
                confirm_password: "",
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
                return this.editedIndex === -1 ? "New Item" : "Edit Item";
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
                document.title = "SCP: CSO² Project | User Management";

                axios.get("/user-roles-permission").then((response) => {
                    const moduleName = "Users";
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

                axios.get("/system-users").then((response_users) => {
                    axios.get("/user-roles").then((response_roles) => {
                        const roles = response_roles.data;
                        const users = response_users.data;
                        let userList = {};
                        for (const keys in users) {
                            userList[keys] = users[keys];
                            let roles_name = "";
                            for (const roles_key in roles)
                                if (users[keys].roles_id == roles[roles_key].id)
                                    roles_name = roles[roles_key].name;
                            userList[keys]["role"] = roles_name;
                        }
                        // this.usersList= userList;
                        this.roles = roles;
                        this.usersList = Object.values(userList);
                        for (const key in roles) {
                            this.filters.filter_items.role.multiple_selection.push({
                                text: roles[key].name,
                                value: roles[key].name,
                            });
                        }
                    });
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
                this.editedIndex = this.usersList.indexOf(item);
                this.editedItem = Object.assign({}, item);
                this.dialog = true;
                // console.log(item);
            },

            deleteItem(item) {
                this.editedIndex = this.usersList.indexOf(item);
                this.editedItem = Object.assign({}, item);
                this.dialogDelete = true;
            },

            deleteItemConfirm() {
                this.btnLoader = true;
                if (this.crud_guard.delete) {
                    axios
                        .post("/delete-user", {
                            id: this.editedItem.id
                        })
                        .then((response) => {
                            if (response.data.success) {
                                this.initialize();
                                this.$noty.success("Successfully deleted.");
                                this.closeDelete();
                            }
                            this.btnLoader = true;
                        });
                }
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
                this.detailsReadonly = false;
                this.dialogDelete = false;
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem);
                    this.editedIndex = -1;
                });
            },

            validateEmail(email) {
                const re =
                    /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            },

            save() {
                let validate = true;
                if (!this.editedItem.firstname) {
                    this.$noty.error("First Name is empty!");
                    validate = false;
                }
                if (!this.editedItem.lastname) {
                    this.$noty.error("Last Name is empty!");
                    validate = false;
                }
                if (!this.editedItem.email) {
                    this.$noty.error("Email is empty!");
                    validate = false;
                }
                if (!this.validateEmail(this.editedItem.email)) {
                    this.$noty.error("Email is not valid!");
                    validate = false;
                }

                if (!this.editedItem.password || this.editedItem.password.length < 8) {
                    this.$noty.error("password should be minimum 8 characters !");
                    validate = false;
                }
                if (!this.editedItem.confirm_password) {
                    this.$noty.error("confirm password can't be empty !");
                    validate = false;
                }

                if (this.editedItem.confirm_password != this.editedItem.password) {
                    this.$noty.error("Password and confirm password should be same ");
                    validate = false;
                }
                if (!this.editedItem.roles_id) {
                    this.$noty.error("The Role of the Account should not be empty");
                    validate = false;
                }

                this.editedItem["id_exist"] = this.editedItem.hasOwnProperty("id");
                if (validate && this.crud_guard.create && this.crud_guard.update) {
                    var formData = new FormData();
                    formData.append("data", JSON.stringify(this.editedItem));
                    axios.post("/save-user", formData).then((response) => {
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
            getColor(status) {
                if (status == "delay") return "red";
                else if (status == "progess") return "blue";
                else if (status == "entry") return "orange";
                else return "green";
            },

            getValue(value) {
                return value;
            },
        },
    };

</script>
