import Swal from 'sweetalert2'

class Alert {
  constructor (options = {}) {
    this.options = options
  }

  title (title) {
    this.options.title = title
    return this
  }

  text (message) {
    this.options.text = message
    return this
  }

  type (type) {
    this.options.type = type
    return this
  }

  success () {
    return this.type('success')
  }

  warning () {
    this.options.focusConfirm = false
    this.confirmButtonColor('var(--color-danger)')
    return this.type('warning')
  }

  error () {
    return this.type('error')
  }

  confirmButtonColor(confirmButtonColor) {
    this.options.confirmButtonColor = confirmButtonColor
    return this
  }

  confirmButtonText(confirmButtonText) {
    this.options.confirmButtonText = confirmButtonText
    return this
  }

  cancelButtonText(cancelButtonText) {
    this.options.showCancelButton = true
    this.options.cancelButtonText = cancelButtonText
    return this
  }

  show () {
    return Swal.fire(this.options)
  }
}

export function alert (options) {
  return new Alert(options)
}

export function initAlerts () {}
