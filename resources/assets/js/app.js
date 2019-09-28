import Vue from 'vue'
import './components'

window.$ = window.jQuery = require('jquery')
require('datatables.net')

const app = new Vue({
    el: '#app'
})

window.$app = app


