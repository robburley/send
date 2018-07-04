/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

window.Vue = require('vue')

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.use(require('vue-moment'))
Vue.use(require('vue2-filters'))

import VModal from 'vue-js-modal'

Vue.use(VModal)

import VueHtml5Editor from 'vue-html5-editor'

import VTooltip from 'v-tooltip'

Vue.use(VTooltip)

Vue.use(VueHtml5Editor, {
    hiddenModules: [
        'image',
        'info',
        'hr',
    ],
})

Vue.component('nav-bar', require('./components/NavBar'))
Vue.component('email-base', require('./components/Emails/Base'))
Vue.component('email-snippet', require('./components/Emails/Snippet'))
Vue.component('email-item', require('./components/Emails/Item'))
Vue.component('email-control', require('./components/Emails/Control'))
Vue.component('email-create', require('./components/Emails/Create'))
Vue.component('email-search', require('./components/Emails/Search'))

Vue.mixin({
    methods: {
        slideFadeIn(el, done) {
            window.velocity(el, 'slideDown', {
                duration: 500,
            })
            window.velocity(el, {
                opacity: 1,
            }, {
                complete: done,
            })
        },
        fadeSlideOut(el, done) {
            window.velocity(el, {
                opacity: 0,
            }, {
                duration: 500,
            })
            window.velocity(el, 'slideUp', {
                complete: done,
            })
        },
    },
})

const app = new Vue({
    el: '#app',
})
