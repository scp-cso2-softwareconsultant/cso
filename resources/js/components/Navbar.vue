<template>
    <v-card
        class="mx-auto"
        width="256"
        tile
    >
        <v-navigation-drawer v-model="drawer" app>
            <v-list>
                <v-list-item link>
                    <v-list-item-content>
                        <v-list-item-title class="text-h6">
                            Administrator
                        </v-list-item-title>
                        <v-list-item-subtitle>System Administrator</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
            <v-divider></v-divider>
            <v-list
                nav
                dense
            >
                <v-list-item-group
                    v-model="selectedItem"
                    color="primary"
                >
                    <div
                        v-for="(item, i) in items"
                        :key="i"
                    >
                        <v-list-item v-if="!item.has_sub_items" :to="item.linkTo">
                            <v-list-item-icon>
                                <v-icon v-text="item.icon"></v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title v-text="item.text"></v-list-item-title>
                            </v-list-item-content>
                            <v-list-item-action v-if="item.has_sub_items">
                                <v-icon>mdi-menu-down</v-icon>
                            </v-list-item-action>
                        </v-list-item>
                    </div>
                </v-list-item-group>
                <v-list-item link @click="logoutUser">
                    <v-list-item-icon>
                        <v-icon>mdi-logout</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>Log Out</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>

        </v-navigation-drawer>
    </v-card>
</template>

<script>
export default {
    data() {
        return {
            drawer: true,
            selectedItem: 0,
            items: [
                { text: 'Dashboard', icon: 'mdi-view-dashboard-outline', linkTo: '/dashboard', has_sub_items: false },
                { text: 'CSO2 Indicator', icon: 'mdi-animation', linkTo: '/cso-indicator', has_sub_items: false },
                { text: 'CSO Profile', icon: 'mdi-animation', linkTo: '/cso-profile', has_sub_items: false },
                { text: 'Assessment', icon: 'mdi-animation', linkTo: '/assessment', has_sub_items: false },
                { text: 'Finance Tracker', icon: 'mdi-finance', linkTo: '/finance-tracker', has_sub_items: false },
                { text: 'Project Tracking Document', icon: 'mdi-finance', linkTo: '/project-tracking-documents', has_sub_items: false },
                { text: 'LMS', icon: 'mdi-finance', linkTo: '/lms-data', has_sub_items: false },
                { text: 'Users', icon: 'mdi-account', linkTo: '/system-users', has_sub_items: false },
            ],

        }
    },
    methods: {
        logoutUser(){
            axios.post('/logout').then( response => {
                window.location.href = "login";
            }).catch((error) =>{
                this.errors = error.response.data.errors;
            })
        }
    }
}
</script>

