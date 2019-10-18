import { alert } from './alert'

export function initDeleteActions () {
  const root = document.querySelector('#app')
  document.querySelectorAll('.delete-single').forEach((el) => {
    el.addEventListener('click', async () => {
      const confirm = await alert()
        .title('Are you sure?')
        .text('You wont be able to revert this!')
        .warning()
        .confirmButtonText('Yes, delete it!')
        .cancelButtonText('No, cancel!')
        .show()

      if (confirm.value) {
        const action = el.dataset.action
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        const form = document.createElement('form')
        form.action = action
        form.method = 'post'
        form.innerHTML = `
            <input type="hidden" name="_token" value="${csrfToken}">
            <input type="hidden" name="_method" value="delete">
        `
        root.appendChild(form)
        form.submit()
      }
    })
  })
}

let onNotifyFn = () => {}
export function onNotify (callback) {
  onNotifyFn = callback
}

export const pushNotification = (notification) => onNotifyFn(notification)

export function initNotifications() {
  const { message } = window.timoneiro
  if (message) {
    pushNotification({
      id: new Date().toUTCString(),
      timeOut: 5000,
      ...message
    })
  }
}