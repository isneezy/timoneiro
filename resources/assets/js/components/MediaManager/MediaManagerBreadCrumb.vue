<template>
  <div class="px-5 py-2 bg-gray-200 font-semibold">
    <ul class="flex justify-start">
      <li :key="folder.path" v-for="(folder, index) in folders" class="flex items-center">
        <a
          href="javascript:void(0)"
          :class="{ 'text-primary': !isLast(index) }"
          @click="onClick(folder)"
        >
          {{ folder.name }}
        </a>
        <i v-if="!isLast(index)" class="mdi mdi-chevron-right text-gray-500"></i>
      </li>
    </ul>
  </div>
</template>

<script>
  export default {
    name: 'MediaManagerBreadCrumb',
    props: {
      current: { default: '/', type: String }
    },
    computed: {
      folders() {
        const names = this.current === null || this.current === '' || this.current === '/' ? [] : this.current.split('/')
        return names.reduce((result, name) => {
          let path = result[result.length - 1].path
          if (path.startsWith('/')) {
            path = path.substr(2, path.length)
          }
          if (path.length) {
            path = path + '/'
          }
          const folder = { name, path: `${path}${name}`}
          result.push(folder)
          return result
        }, [{ name: 'Media Manager', path: '' }])
      }
    },
    methods: {
      isLast(index) {
        return this.folders.length -1 === index
      },
      onClick(folder) {
        this.$emit('changeDir', folder.path)
      }
    }
  }
</script>