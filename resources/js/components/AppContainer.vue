<template>
    <v-app>
        <navbar ref="navbar"></navbar>
        <app-header @toggle-drawer="$refs.navbar.drawer = !$refs.navbar.drawer"></app-header>
        <v-main>
            <v-container>
                <router-view></router-view>
            </v-container>
        </v-main>
        <app-footer></app-footer>
    </v-app>

</template>

<script>
import Navbar from './Navbar'
import Header from './Header'
import Footer from './Footer'
import Router from '../router';

export default {
    data: () => ({
        drawer: null,
    }),
    components: {
        'navbar': Navbar,
        'app-header': Header,
        'app-footer': Footer
    },
    created(){
        // Router.push('/dashboard').catch(err => {})
    }
}
</script>
