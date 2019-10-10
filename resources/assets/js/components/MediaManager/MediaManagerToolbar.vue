<template>
  <div>
    <div class="bg-gray-300 p-3 flex">
      <div class="mr-8">
        <button class="appearance-none bg-primary py-2 px-3 text-white rounded-l" @click="selectFiles">
          <i class="mdi mdi-upload"></i>
          <span>Upload</span>
          <input ref="input" multiple type="file" class="hidden" @change="uploadFiles">
        </button>
        <button class="appearance-none bg-primary py-2 px-3 text-white rounded-r -ml-1 border-l" @click="onCreateFolder">
          <i class="mdi mdi-folder-plus"></i>
          <span>Add Folder</span>
        </button>
      </div>
      <button class="appearance-none bg-white py-2 px-3 rounded" @click="$emit('refresh')">
        <i class="mdi mdi-reload"></i>
      </button>
      <div class="ml-8">
        <button class="appearance-none bg-white py-2 px-3 rounded-l">
          <i class="mdi mdi-folder-move"></i>
          <span>Move</span>
        </button>
        <button class="appearance-none bg-white py-2 px-3 -ml-1 border-l" @click="onRename">
          <i class="mdi mdi-textbox"></i>
          <span>Rename</span>
        </button>
        <button class="appearance-none bg-white py-2 px-3 -ml-1 rounded-r border-l" @click="onDeleteFile">
          <i class="mdi mdi-delete"></i>
          <span>Delete</span>
        </button>
      </div>
    </div>
    <div v-if="progress" class="w-full">
      <div class="shadow w-full bg-gray-500">
        <div class="bg-success text-xs leading-none py-1 text-center text-white" :style="`width: ${progress}%`">{{ progress }}%</div>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from 'axios'
  export default {
    name: 'MediaManagerToolbar',
    props: {
      current: { type: String, required: true, default: '' },
      basePath: { type: String, required: true },
      selected: { type: Object, default: null }
    },
    data: () => ({
      progress: 0
    }),
    methods: {
      onCreateFolder() {
        const name = window.prompt('Name of the folder')
        if (name) {
          const path = this.current || ''
          this.$emit('createFolder', path + '/' + name)
        }
      },
      selectFiles() {
        this.$refs.input.click()
      },
      async uploadFiles({ target: input }) {
        this.progress = 1
        const data = new FormData()
        data.append('path', this.current)
        for(let i = 0; i < input.files.length; i++) {
          data.append(`files_${i}`, input.files[i])
        }
        await axios.post(`${this.basePath}/upload`, data, {
          'Content-Type': 'multipart/form-data',
          onUploadProgress: this.onDownloadProgress,
        })
        this.progress = 0
        this.$emit('refresh')
      },
      onUploadProgress(e) {
        this.progress = Math.round((e.load * 100) / e.total)
      },
      async onRename() {
        const name = window.prompt(
          `Rename ${this.selected.name}`,
          this.selected.name
        )
        if (name) {
          await axios.post(`${this.basePath}/rename`, {
            path: this.current,
            file: this.selected,
            name
          })
          this.$emit('refresh')
        }
      },
      async onDeleteFile() {
        const confirm = window.confirm('Are you sure want to delete the selected file(s)?\nNote: this can\'t be undone.')
        if (confirm) {
          await axios.post(`${this.basePath}/delete`, {
            path: this.current,
            files: [this.selected]
          })
          this.$emit('refresh')
        }
      }
    }
  }
</script>

<style scoped>

</style>