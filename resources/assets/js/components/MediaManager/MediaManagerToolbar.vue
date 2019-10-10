<template>
  <div class="bg-gray-300 p-3 flex">
    <div class="mr-8">
      <button class="appearance-none bg-primary py-2 px-3 text-white rounded-l">
        <i class="mdi mdi-upload"></i>
        <span>Upload</span>
      </button>
      <button class="appearance-none bg-primary py-2 px-3 text-white rounded-r -ml-1 border-l" @click="onCreateFolder">
        <i class="mdi mdi-folder-plus"></i>
        <span>Add Folder</span>
      </button>
    </div>
    <button class="appearance-none bg-white py-2 px-3 rounded">
      <i class="mdi mdi-reload"></i>
    </button>
    <div class="ml-8">
      <button class="appearance-none bg-white py-2 px-3 rounded-l">
        <i class="mdi mdi-folder-move"></i>
        <span>Move</span>
      </button>
      <button class="appearance-none bg-white py-2 px-3 -ml-1 border-l">
        <i class="mdi mdi-textbox"></i>
        <span>Rename</span>
      </button>
      <button class="appearance-none bg-white py-2 px-3 -ml-1 rounded-r border-l">
        <i class="mdi mdi-delete"></i>
        <span>Delete</span>
      </button>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'MediaManagerToolbar',
    props: {
      current: { type: String, required: true, default: '' }
    },
    methods: {
      onCreateFolder() {
        const name = window.prompt('Name of the folder')
        if (name) {
          const path = this.current || ''
          this.$emit('createFolder', path + '/' + name)
        }
      }
    }
  }
</script>

<style scoped>

</style>