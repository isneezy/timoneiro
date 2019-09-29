import Vue from 'vue'
import './components'

window.$ = window.jQuery = require('jquery')
require('datatables.net')

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


