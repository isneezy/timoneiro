<template>
  <div class="relative" :class="wrapperClass" @click.native="openFileChooser">
    <input ref="input" :name="name" class="absolute top-0" style="height: 0" :value="inputValue">
    <slot v-if="!files.length" name="empty"/>
    <div class="flex flex-wrap -mx-2">
      <FileInputItem :key="index" v-for="(file, index) in files" :item="file" />
    </div>
    <FileChooser :base-path="basePath" :visible="chooserVisible" @change="onChange" @close="chooserVisible = false" />
  </div>
</template>

<script>
  import FileInputItem from './FileInputItem'
  import FileChooser from './FileChooser'

  export default {
    name: 'FileInput',
    components: {FileChooser, FileInputItem},
    props: {
      value: {type: [String, Array], default: ''},
      name: {required: true},
      wrapperClass: { type: String, default: '' },
      basePath: { type: String }
    },
    data() {
      let files = []
      try {
        files = Array.isArray(this.value) ? this.value : JSON.parse(this.value)
      }catch (e) {

      }
      return {
        chooserVisible: false,
        files
      }
    },
    mounted() {
      this.$refs.input.addEventListener('focus', (e) => {
        this.openFileChooser(e)
      })
    },
    computed: {
      inputValue() {
        return JSON.stringify(this.files)
      }
    },
    methods: {
      openFileChooser(e) {
        e.preventDefault()
        this.chooserVisible = true;
      },
      onChange(file) {
        this.files.push(file.path)
      }
    }
  }
</script>