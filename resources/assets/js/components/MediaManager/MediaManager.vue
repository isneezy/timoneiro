<template>
  <div class="bg-white rounded overflow-hidden">
    <MediaManagerToolbar @createFolder="onCreateFolder"/>
    <MediaManagerBreadCrumb :current="currentFolder" @changeDir="changeDir"  />
    <div class="flex">
      <div class="flex-1 p-5">
        <MediaManagerContentList
          v-if="!loading"
          :items="files"
          :selected="selectedFile"
          @select="onSelect"
          @changeDir="changeDir"
        />
        <div v-else class="p-5 text-center">
          <i class="mdi mdi-coffee"></i>
          <span>Loading please wait...</span>
        </div>
      </div>
      <div class="w-1/4 p-5 border-l">
        <div v-if="selectedFile">
          <p class="font-semibold text-base">{{ selectedFile.name }}</p>
          <p v-if="selectedFile.size">{{ selectedFile.size / 1000 }}kb</p>
          <p>{{ selectedFile.type }}</p>
          <p>{{ selectedFile.last_modified }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import MediaManagerToolbar from './MediaManagerToolbar'
  import MediaManagerContentList from './MediaManagerContentList'
  import MediaManagerBreadCrumb from './MediaManagerBreadCrumb'

  export default {
    name: 'MediaManager',
    props: {
      basePath: { required: true, type: String }
    },
    data: () => ({
      files: [],
      selectedFile: null,
      currentFolder: null,
      loading: false
    }),
    mounted() {
      this.changeDir()
    },
    components: {
      MediaManagerBreadCrumb,
      MediaManagerContentList,
      MediaManagerToolbar
    },
    methods: {
      async changeDir(folder = '/') {
        this.currentFolder = folder
        try {
          this.loading = true
          const response = await fetch(`${this.basePath}/files?folder=${folder}`)
          this.files = await response.json()
          this.selectedFile = null
        } finally {
          this.loading = false
        }
      },
      onSelect(file) {
        this.selectedFile = file
      },
      async onCreateFolder(name) {
        name = this.currentFolder + '/' + name
        try {
          this.loading = true
          await fetch(`${this.basePath}/new-folder`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              new_folder: name
            })
          })
          await this.changeDir(this.currentFolder)
        }finally {
          this.loading = false
        }
      }
    }
  }
</script>