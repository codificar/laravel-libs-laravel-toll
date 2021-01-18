window.vue = require('vue');

require('lodash');

import Vue from 'vue';

Vue.prototype.trans = (key) => {
    return _.get(window.lang, key, key);
};

import pagination from 'laravel-vue-pagination';
Vue.component('pagination', pagination);

import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);

import settings from './pages/settings';
import tolllist from './pages/toll_list';
import tolladd from './pages/toll_add_modal';
import tollcategory from './pages/toll_category_list';

new Vue({
    el: '#toll',
    data: {
        showModal: false
    },
    components: {
        tolllist,
        tolladd,
        tollcategory,
        settings
    }
});