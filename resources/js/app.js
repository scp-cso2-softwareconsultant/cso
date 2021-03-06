/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue').default;
import Vuetify from "../plugins/vuetify";
import MultiFiltersPlugin from '../plugins/MultiFilters' //Vuetify data-table multi filter 
import "../plugins/vuetify-money.js";
import router from "./router";
Vue.use(MultiFiltersPlugin); // <-- THIS
Vue.use(Vuetify);
/**
  * The following block of code may be used to automatically register your
  * Vue components. It will recursively scan this directory for the Vue
  * components and automatically register them with their "basename".
  *
  * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
  */
 // const files = require.context('./', true, /\.vue$/i)
 // files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

 // Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('app-container', require('./components/AppContainer').default);

import VueApexCharts from 'vue-apexcharts';
Vue.use(VueApexCharts);
Vue.component('apexchart', VueApexCharts);

Vue.mixin({
  methods:{
    limitChipName(chipname) {
      if (chipname.length >= 36) {
        var nameOfFile = chipname.substring(0, 36);
        var nameOfExtension = chipname.substring(chipname.lastIndexOf("."));
        var newChipName = nameOfFile + "...." + nameOfExtension;
        return newChipName;
      }
      return chipname;
    },
    isNotDefine(item) {
      return item == null || item.length === 0 || item === undefined;
    }
  }
})
/**
  * Next, we will create a fresh Vue application instance and attach it to
  * the page. Then, you may begin adding components to this application
  * or customize the JavaScript scaffolding to fit your unique needs.
  */
const app = new Vue({
    vuetify: Vuetify,
    router,
    el: '#app',
});
