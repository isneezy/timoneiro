<template>
  <div
    class="w-1/6 px-2 mb-2 cursor-move relative"
    @click.prevent=""
    @mouseover="hover = true"
    @mouseleave="hover = false"
  >
    <a
      v-if="hover"
      href="javascript:void(0)"
      @click="$emit('remove')"
      class="
        flex z-10 h-6 w-6 rounded-full bg-danger absolute top-0 right-0
        justify-center items-center -my-2 -mx-1 shadow text-white
      "
    >
      <i class="mdi mdi-close"></i>
    </a>
    <div class="rounded overflow-hidden bg-gray-200 relative relative h-24" :title="name">
      <div v-if="isImage" :style="style" class="h-full w-full bg-cover bg-center"></div>
      <div v-else class="flex items-center justify-center h-full">
        <div class="w-full text-center p-2">
          <p class="text-3xl"><i class="mdi mdi-file"></i></p>
          <p class="truncate text-xs">{{ name }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'FileInputItem',
    props: {
      item: { type: [String, Object], require: true }
    },
    data: () => ({
      hover: false
    }),
    computed: {
      style() {
        const style = {}
        style.backgroundImage = `url("${this.item}")`
        style.zIndex = 0
        return style
      },
      isImage() {
        return ['jpeg', 'jpg', 'png', 'svg', 'gif'].some(ext => this.item.endsWith(ext))
      },
      name() {
        return this.item.substr(this.item.lastIndexOf('/') + 1)
      }
    }
  }
</script>