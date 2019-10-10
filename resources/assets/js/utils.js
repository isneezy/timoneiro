export function isImage(file) {
  if (!file) return false
  return ['image/png', 'image/jpeg', 'image/svg+xml'].includes(file.type)
}

export function getLocate () {
  return document.querySelector('html').getAttribute('lang') || 'en'
}