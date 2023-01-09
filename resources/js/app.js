import './bootstrap';
import Vue from "vue";

import ExampleComponent from './views/Board.vue';
Vue.component('example-component', ExampleComponent);

import vmodal from 'vue-js-modal'
Vue.use(vmodal, { componentName: 'CardModal' })

const app = new Vue({
    el: '#app',
    mounted() {
        console.log('Hello AYaz I am here now')
    }
})
