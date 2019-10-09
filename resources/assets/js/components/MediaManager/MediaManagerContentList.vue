<template>
  <div class="flex flex-wrap -mx-2">
    <div :key="item.path" v-for="item in items" class="w-1/4 px-2">
      <MediaManagerContentListItem
        :item="item"
        :active="isSelected(item)"
        @click.native="onClick(item)"
        @dblclick.native="onDblclick(item)"
      />
    </div>
  </div>
</template>

<script>
  import MediaManagerContentListItem from './MediaManagerContentListItem'
  export default {
    name: 'MediaManagerContentList',
    props: {
      items: { type: Array, default: [] },
      selected: { type: Object, default: null }
    },
    components: { MediaManagerContentListItem },
    methods: {
      onClick(item) {
        this.$emit('select', item)
      },
      onDblclick(item) {
        if (item.type === 'folder') {
          this.$emit('changeDir', item.relative_path)
        }
      },
      isSelected(item) {
        if ( this.selected) {
          return this.selected.path === item.path
        }
        return false
      }
    }
  }
</script>
