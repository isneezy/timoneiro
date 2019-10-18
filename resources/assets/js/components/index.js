import Vue from 'vue'
import FormSelect from './FormSelect'
import MediaManager from './MediaManager/MediaManager'
import FileInput from './FileInput'
import DropDown from './DropDown'
import ToastNotifications from './Toast/ToastNotifications'

Vue.component('form-select', FormSelect)
Vue.component('media-manager', MediaManager)
Vue.component('file-input', FileInput)
Vue.component('dropdown', DropDown)
Vue.component('toast-notifications', ToastNotifications)