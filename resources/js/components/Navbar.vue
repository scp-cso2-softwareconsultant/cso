<template>
    <v-card class="mx-auto" width="256" tile>
        <v-navigation-drawer class="app-side-bar" v-model="drawer" app>
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
            <v-list class="mt-1" nav dense >
                <v-list-item-group v-model="selectedItem" color="secondary">
                    <div v-for="(item, i) in items" :key="i" >
                        <v-list-item class="px-1 my-3 nav-btn-desu" v-if="!item.has_sub_items && !item.linkTo.includes('https:')" :to="item.linkTo" >
                            <v-list-item-icon class='p-2 bg-white nav-list-icon'>
                                <v-icon v-text="item.icon"></v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title v-text="item.text"></v-list-item-title>
                            </v-list-item-content>
                            <v-list-item-action v-if="item.has_sub_items">
                                <v-icon>mdi-menu-down</v-icon>
                            </v-list-item-action>
                        </v-list-item>
                        <v-list-item class="px-1 my-3 nav-btn-desu" v-else-if="!item.has_sub_items" v-bind:href="item.linkTo" >
                            <v-list-item-icon class='p-2 bg-white nav-list-icon'>
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
                <v-list-item class="px-1 my-3 nav-btn-desu" link @click="logoutUser">
                    <v-list-item-icon class='p-2 bg-white nav-list-icon'>
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
                { text: 'CSO² Project Indicator', icon: 'mdi-animation', linkTo: '/cso-indicator', has_sub_items: false },
                { text: 'CSO Profile', icon: 'mdi-animation', linkTo: '/cso-profile', has_sub_items: false },
                { text: 'Assessment', icon: 'mdi-animation', linkTo: '/assessment', has_sub_items: false },
                { text: 'Finance Tracker', icon: 'mdi-finance', linkTo: '/finance-tracker', has_sub_items: false },
                { text: 'Project Tracking Document', icon: 'mdi-finance', linkTo: '/project-tracking-documents', has_sub_items: false },
                { text: 'LMS', icon: 'mdi-finance', linkTo: '/lms-data', has_sub_items: false },
                { text: 'Users', icon: 'mdi-account', linkTo: '/system-users', has_sub_items: false },
                { text: 'Acitiviy Feedbacking', icon: 'mdi-archive-arrow-up-outline', linkTo: 'https://cso2projectdatabase.000webhostapp.com/activity_feedback.php', has_sub_items: false },
                { text: 'CBLD Indicators', icon: 'mdi-archive-arrow-up-outline', linkTo: 'https://cso2projectdatabase.000webhostapp.com/cbld.php', has_sub_items: false },
                { text: 'DIS', icon: 'mdi-archive-arrow-up-outline', linkTo: 'https://cso2projectdatabase.000webhostapp.com/dis.php', has_sub_items: false },
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


<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');

.app-side-bar{
    background-color: transparent;
    background-image: url('/img/navbar_back_grad.png');
    font-family: 'Poppins', sans-serif;
    font-weight: 800;
}

.nav-list-icon{
    border-radius: 6px;
}

i.v-icon.v-icon {
  color: #2E3A59;
} 

.nav-btn-desu{
    cursor: pointer;
    text-decoration: none;
    border-radius: 6px;
}

.nav-btn-desu:hover{
    transition: 0.2s ease-in-out;
    background-color: #e0e0e0;
}
</style>