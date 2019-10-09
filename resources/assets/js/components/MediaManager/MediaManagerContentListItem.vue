<template>
  <div
    class="rounded p-1 mb-2 flex items-center cursor-pointer select-none overflow-hidden"
    :class="className"
    :title="item.name"
    @mouseover="isHover = true"
    @mouseout="isHover = false"
  >
    <div class="w-1/3 mr-2 flex items-center justify-center h-12">
      <i class="mdi mdi-folder text-4xl"></i>
    </div>
    <div>
      <p class="font-bold truncate">{{ item.name }}</p>
      <p v-if="!isFolder" class="text-xs">{{ fileSize }}kb</p>
    </div>
  </div>
</template>

<script>
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
        className['bg-primary'] = this.hasFocus

        className['text-white'] = this.hasFocus
        return className
      },
      isFolder() {
        return this.item.type === 'folder'
      },
      fileSize() {
        return  (this.item.size / 1000).toFixed(1)
      }
    }
  }
</script>
