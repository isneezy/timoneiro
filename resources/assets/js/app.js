import Vue from 'vue'
import VueCompositionApi from '@vue/composition-api'
import { onMounted } from '@vue/composition-api'
import PortalVue from 'portal-vue'
import axios from 'axios'
import './components'
import { initDeleteActions } from './helpers'

window.$ = window.jQuery = require('jquery')

axios.defaults.headers['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

Vue.use(PortalVue)
Vue.use(VueCompositionApi)

$(document).ready(function () {
  const searchForm = $('#search-form')
  $('#search-form select').change(() => {
    searchForm.submit()
  })
})

const app = new Vue({
  el: '#app',
  setup () {
    onMounted(() => {
      initDeleteActions()
    })
  }
})

window.$app = app


