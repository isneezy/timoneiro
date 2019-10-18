import { pushNotification } from './index'

class Notification {
  constructor (options = {}) {
    this.options = options
  }

  title (title) {
    this.options.title = title
    return this
  }

  message (message) {
    this.options.message = message
    return this
  }

  variant (variant) {
    this.options.variant = variant
    return this
  }

  success () {
    this.title(this.options.title || 'Good job!')
    return this.variant('success')
  }

  error () {
    this.title(this.options.title || 'Woops!')
    return this.variant('danger')
  }

  warning () {
    this.title(this.options.title || 'Attention!')
    return this.variant('warning')
  }

  toast() {
    pushNotification(this.options)
  }
}

export const notification = (options = {}) => new Notification(options)