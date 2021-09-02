import Vue from 'vue';
import VueRouter from "vue-router";

Vue.use(VueRouter)


import Dashboard from '../pages/Dashboard';
import CSOIndicator from "../pages/CSOIndicator";
import CSOProfile from "../pages/CSOProfile";
import Assessment from "../pages/Assessment";
import FinanceTracker from "../pages/FinanceTracker";
import ProjectTrackingDocuments from "../pages/ProjectTrackingDocuments";
import LMS from "../pages/LMS";
import Users from "../pages/SystemUser";

import axios from "axios";



// axios.get('/user-roles-permission').then( response => {
//     const data = response.data;
//     for( var i = 0 ; i < this.item_list.length ; i++){
//         const name = this.item_list[i].name;
//         if(  typeof name == "undefined" )
//             this.items.push(this.item_list[i]);
//         else
//            for (var key in data) 
//                 if( data[key].name ==  name && data[key].crud_guard[0].view )
//                     this.items.push(this.item_list[i]);
//     }
// })

const restrict_paths=()=>{
    const routes = [
        {
            component: Dashboard,
            name: "Dashboard",
            path: "/app"
        },
        {
            component: Dashboard,
            name: "Dashboard",
            path: "/dashboard"
        },
        {
            component: CSOIndicator,
            name: "CSOIndicator",
            path: "/cso-indicator"
        },
        {
            component: CSOProfile,
            name: "CSOProfile",
            path: "/cso-profile"
        },
        {
            component: Assessment,
            name: "Assessment",
            path: "/assessment"
        },
        {
            component: FinanceTracker,
            name: "FinanceTracker",
            path: "/finance-tracker"
        },
        {
            component: ProjectTrackingDocuments,
            name: "ProjectTrackingDocuments",
            path: "/project-tracking-documents"
        },
        {
            component: LMS,
            name: "LMS",
            path: "/lms-data"
        },
        {
            component: Users,
            name: "Users",
            path: "/system-users"
        },
    
    ];
    axios.get('/user-roles-permission').then( response => {
        // const data = response.data;
        // for( var i = 0 ; i < this.item_list.length ; i++){
        //     const name = this.item_list[i].name;
        //     if(  typeof name == "undefined" )
        //         this.items.push(this.item_list[i]);
        //     else
        //        for (var key in data) 
        //             if( data[key].name ==  name && data[key].crud_guard[0].view )
        //                 this.items.push(this.item_list[i]);
        // }
    })
    return routes;


}

export default  new VueRouter(
    {
        routes:restrict_paths()
    }
);
