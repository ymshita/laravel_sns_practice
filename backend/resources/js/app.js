// require('./bootstrap');
// require('alpinejs');

import './bootstrap'
import 'alpinejs'
import Vue from 'vue'
import ArticleLike from './components/ArticleLike'

const app = new Vue({
    el: '#app',
    components: {
        ArticleLike,
    }
})
