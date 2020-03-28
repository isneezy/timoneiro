<template>
  <portal to="modals">
    <div v-if="visible" class="fixed top-0 bottom-0 right-0 left-0 w-full z-40 overflow-auto flex" style="background-color: rgba(0,0,0,.5)">
      <div class="relative flex w-full max-w-5xl flex-col m-auto">
        <media-manager :base-path="basePath" chooser @change="onChange" @close="$emit('close')" :mime-types="mimeTypes" />
      </div>
    </div>
  </portal>
</template>

<script>
  export default {
    name: 'FileChooser',
    props: ['basePath', 'visible', 'mimeTypes'],
    methods: {
      onChange(file) {
        this.$emit('change', file)
        this.$emit('close')
      }
    }
  }
</script>