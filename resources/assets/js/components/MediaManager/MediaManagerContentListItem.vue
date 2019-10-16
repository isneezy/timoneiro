<template>
  <div
    class="rounded p-1 mb-2 flex items-center cursor-pointer select-none overflow-hidden"
    :class="className"
    :title="item.name"
    @mouseover="isHover = true"
    @mouseout="isHover = false"
  >
    <div class="w-1/3 mr-2 flex items-center justify-center h-12">
      <img class="max-h-full max-w-full" v-if="isImage" :src="item.path" :alt="item.name">
      <i v-else class="mdi text-4xl" :class="icon"></i>
    </div>
    <div class="w-2/3">
      <p class="font-bold truncate">{{ item.name }}</p>
      <p v-if="!isFolder" class="text-xs">{{ fileSize }}kb</p>
    </div>
  </div>
</template>

<script>
  import { isImage } from '../../utils'

  export default {
    name: 'MediaManagerContentListItem',
    props: {
      active: { default: false, type: Boolean },
      item: { type: Object, required: true }
    },
    data: () => ({
      isHover: false
    }),
    computed: {
      hasFocus() {
        return this.active
      },
      className() {
        const className = {}
        className['bg-gray-200'] = !this.isHover && !this.hasFocus
        className['bg-gray-300'] = this.isHover && !this.hasFocus
        className['bg-info'] = this.hasFocus

        className['text-white'] = this.hasFocus
        return className
      },
      isFolder() {
        return this.item.type === 'folder'
      },
      fileSize() {
        return  (this.item.size / 1000).toFixed(1)
      },
      icon() {
        const icon = icons[this.item.type] || 'mdi-file-alert'
        return icon
      },
      isImage() {
        return isImage(this.item)
      }
    }
  }
  const icons = {
    'folder': 'mdi-folder',
    'text/plain': 'mdi-file-document',
    'application/pdf': 'mdi-file-pdf',
    'application/msword': 'mdi-file-word',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document': 'mdi-file-word',
    'application/vnd.ms-excel': 'mdi-file-excel'
  };
</script>
