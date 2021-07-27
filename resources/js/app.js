require("./bootstrap");

window.Vue = require("vue").default;

import Form from "vform";
import { HasError, AlertError } from "vform/src/components/bootstrap5";
import Vue from "vue";
import VueRouter from "vue-router";
import Barang from "./components/Barang.vue";
import Dashboard from "./components/Dashboard.vue";
import FotoBarang from "./components/FotoBarang.vue";
import FotoBarangDetail from "./components/FotoBarangDetail.vue";
import Swal from "sweetalert2";
import VueProgressBar from "vue-progressbar";
import VueCurrencyFilter from "vue-currency-filter";

// START: Form input Axios vfrom
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
// END: Form input Axios vfrom

// START: Load data tanpa refresh page
let newVue = new Vue();
window.newVue = newVue;
// END: Load data tanpa refresh page

// START: Sweetalert2
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000
});
window.Toast = Toast;
// END: Sweetalert2

// START: Vue Progressbar
Vue.use(VueProgressBar, {
    color: "rgb(143, 255, 199)",
    failedColor: "red",
    thickness: "5px",
    transition: {
        speed: "0.2s",
        opacity: "0.6s",
        termination: 300
    },
    autoRevert: true,
    location: "top",
    inverse: false
});
// END: Vue Progressbar

// START: Vue Currency Filter
Vue.use(VueCurrencyFilter, {
    symbol: "IDR",
    thousandsSeparator: ".",
    fractionCount: 0,
    fractionSeparator: ",",
    symbolPosition: "front",
    symbolSpacing: true,
    avoidEmptyDecimals: undefined
});
// END: Vue Currency Filter

// START: Vue Router
Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        name: "Dashboard",
        component: Dashboard
    },
    {
        path: "/barang",
        name: "Barang",
        component: Barang
    },
    {
        path: "/foto-barang",
        name: "FotoBarang",
        component: FotoBarang
    },
    {
        path: "/foto-barang-detail/:id",
        name: "FotoBarangDetail",
        component: FotoBarangDetail,
        props: true
    }
];

const router = new VueRouter({
    routes,
    linkExactActiveClass: "active"
});
// END: Vue Router

const app = new Vue({
    el: "#app",
    router
});
