<template>
  <div v-if="selectedFile">
    <img class="w-full" v-if="isImage" :src="selectedFile.path" :alt="selectedFile.name">
    <p>
      <span class="text-gray-500">Title:</span>
      <span class="font-semibold">{{ selectedFile.name }}</span>
    </p>
    <p>
      <span class="text-gray-500">Type:</span>
      <span class="font-semibold">{{ selectedFile.type }}</span>
    </p>
    <p v-if="selectedFile.size">
      <span class="text-gray-500">Size:</span>
      <span class="font-semibold">{{ selectedFile.size / 1000 }}kb</span>
    </p>
    <p>
      <span class="text-gray-500">Public URL:</span>
      <a :href="selectedFile.path" target="_blank" class="font-semibold text-primary">Click here</a>
    </p>
    <p>
      <span class="text-gray-500">Last Modified:</span>
      <span class="font-semibold">{{(new Date(selectedFile.last_modified)).toLocaleString(locale) }}</span>
    </p>
  </div>
</template>

<script>
  import { getLocate, isImage } from '../../utils'

  export default {
    name: 'MediaFileInfo',
    props: {
      selectedFile: { type: Object, default: null }
    },
    computed: {
      isImage() {
        return isImage(this.selectedFile)
      },
      locale() {
        return getLocate()
      }
    },
  }
</script>

<style scoped>

</style>