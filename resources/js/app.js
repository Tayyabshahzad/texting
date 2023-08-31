/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import vuetify from './vuetify';


import VueApexCharts from 'vue-apexcharts'
Vue.use(VueApexCharts)

Vue.component('apexchart', VueApexCharts)
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('customer-dashboard', require('./components/CustomerDashboard.vue').default);
Vue.component('user-dashboard', require('./components/UserDashboard.vue').default);
Vue.component('profile', require('./components/Profile.vue').default);
Vue.component('redeem', require('./components/Redeem.vue').default);

Vue.component('register-component', require('./components/RegisterComponent.vue').default);
Vue.component('login-component', require('./components/LoginComponent.vue').default);

Vue.component('admin-tools', require('./components/AdminTools.vue').default);
Vue.component('purchase-plan', require('./components/PurchasePlan.vue').default);

Vue.component('reset-password-phone', require('./components/auth/ResetPasswordPhone.vue').default);
Vue.component('reset', require('./components/auth/Reset.vue').default);

Vue.component('survey', require('./components/Survey.vue').default);
Vue.component('create-survey', require('./components/CreateSurvey.vue').default);
Vue.component('customer-survey', require('./components/ViewSurvey.vue').default);
Vue.component('signup-survey', require('./components/SignupSurvey.vue').default);
Vue.component('live-signup', require('./components/LiveSignup.vue').default);


Vue.component('test-sms', require('./components/TestSms.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify,
});
