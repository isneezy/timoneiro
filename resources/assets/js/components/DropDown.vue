<template>
  <div class="relative" v-click-outside="hide">
    <div @click="toggle">
      <slot name="label"/>
    </div>
    <div v-if="open"  class="absolute right-0">
      <slot name="items" />
    </div>
  </div>
</template>

<script>
  import clickOutside from 'vue-click-outside'
  export default {
    name: 'DropDown',
    props: ['title'],
    data: () => ({
      open: false
    }),
    methods: {
      hide() {
        this.open = false
      },
      toggle() {
        this.open = !this.open
      }
    },
    directives: {
      clickOutside
    }
  }
</script>