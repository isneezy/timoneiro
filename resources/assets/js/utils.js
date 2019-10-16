export function isImage(file) {
  if (!file) return false
  return ['image/png', 'image/jpeg', 'image/svg+xml'].includes(file.type)
}

export function getLocate () {
  return document.querySelector('html').getAttribute('lang') || 'en'
}

export function uuidv4() {
  return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
    const r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
    return v.toString(16);
  });
}