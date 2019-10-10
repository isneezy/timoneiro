import Vue from 'vue'
import axios from 'axios'
import './components'

window.$ = window.jQuery = require('jquery')
require('datatables.net')

axios.defaults.headers['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

$(document).ready(function () {
    const searchForm = $('#search-form')
    $('#search-form select').change(() => {
        searchForm.submit()
    })
})

const app = new Vue({
    el: '#app'
})

window.$app = app


