<template>
  <div class="bg-white rounded overflow-hidden">
    <MediaManagerToolbar/>
    <div class="flex">
      <div class="flex-1 p-5">
        <MediaManagerContentList
          v-if="!loading"
          :items="files"
          :selected="selected"
          @select="onSelect"
          @changeDir="changeDir"
        />
        <div v-else class="p-5 text-center">
          <i class="mdi mdi-coffee"></i>
          <span>Loading please wait...</span>
        </div>
      </div>
      <div class="w-1/4 p-5 border-l">
        A
      </div>
    </div>
  </div>
</template>

<script>
  import MediaManagerToolbar from './MediaManagerToolbar'
  import MediaManagerContentList from './MediaManagerContentList'

  export default {
    name: 'MediaManager',
    props: {
      basePath: { required: true, type: String }
    },
    data: () => ({
      files: [],
      selected: null,
      loading: false
    }),
    mounted() {
      this.changeDir('/')
    },
    components: {
      MediaManagerContentList,
      MediaManagerToolbar
    },
    methods: {
      async changeDir(folder) {
        try {
          this.loading = true
          const response = await fetch(`${this.basePath}/files?folder=${folder}`)
          this.files = await response.json()
        } finally {
          this.loading = false
        }
      },
      onSelect(file) {
        this.selected = file
      }
    }
  }
</script>