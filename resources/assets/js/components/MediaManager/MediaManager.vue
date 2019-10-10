<template>
  <div class="bg-white rounded overflow-hidden">
    <MediaManagerToolbar
      :base-path="basePath"
      :current="currentFolder"
      :selected="selectedFile"
      @createFolder="onCreateFolder"
      @refresh="changeDir(currentFolder)"
    />
    <MediaManagerBreadCrumb :current="currentFolder" @changeDir="changeDir"  />
    <div class="flex" style="min-height: 264px">
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
        <MediaFileInfo :selectedFile="selectedFile" />
      </div>
    </div>
  </div>
</template>

<script>
  import MediaManagerToolbar from './MediaManagerToolbar'
  import MediaManagerContentList from './MediaManagerContentList'
  import MediaManagerBreadCrumb from './MediaManagerBreadCrumb'
  import MediaFileInfo from './MediaFileInfo'

  export default {
    name: 'MediaManager',
    components: {
      MediaFileInfo,
      MediaManagerBreadCrumb,
      MediaManagerContentList,
      MediaManagerToolbar
    },
    props: {
      basePath: { required: true, type: String }
    },
    data: () => ({
      files: [],
      selectedFile: null,
      currentFolder: '',
      loading: false
    }),
    mounted() {
      this.changeDir()
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
      async onCreateFolder(new_folder) {
        try {
          this.loading = true
          await fetch(`${this.basePath}/new-folder`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              new_folder
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