<template>
  <div class="relative" :class="wrapperClass" @click.native="openFileChooser">
    <input ref="input" :name="name" class="absolute top-0" style="height: 0" :value="inputValue">
    <slot v-if="!files.length" name="empty"/>
    <div class="flex flex-wrap -mx-2">
      <FileInputItem :key="index" v-for="(file, index) in files" :item="file" @remove="remove(file)"/>
    </div>
    <FileChooser :base-path="basePath" :visible="chooserVisible" @change="onChange" @close="chooserVisible = false"/>
  </div>
</template>

<script>
  import FileInputItem from './FileInputItem'
  import FileChooser from './FileChooser'

  export default {
    name: 'FileInput',
    components: {FileChooser, FileInputItem},
    props: {
      value: {type: String, default: ''},
      name: {required: true},
      wrapperClass: {type: String, default: ''},
      basePath: {type: String},
      multiple: {default: false, type: Boolean}
    },
    data: () => ({
      chooserVisible: false,
      files: []
    }),
    mounted () {
      this.initValues()
      this.$refs.input.addEventListener('focus', (e) => {
        this.openFileChooser(e)
      })
      this.$el.closest('form').addEventListener('reset', e => {
        this.initValues()
      })
    },
    computed: {
      inputValue () {
        if (this.multiple) {
          return JSON.stringify(this.files)
        }
        if (this.files.length) return this.files[0]
        return ''
      }
    },
    methods: {
      openFileChooser (e) {
        e.preventDefault()
        this.chooserVisible = true
      },
      onChange (file) {
        if (this.multiple) {
          this.files.push(file.path)
        } else {
          this.files = [file.path]
        }
      },
      remove (file) {
        this.files = this.files.filter(f => f !== file)
      },
      initValues() {
        let files = []
        try {
          files = Array.isArray(this.value) ? this.value : JSON.parse(this.value)
        }catch (e) {
          if (!this.multiple && this.value.length) files.push(this.value)
        }
        this.files = files
      }
    }
  }
</script>