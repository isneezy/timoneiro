<template>
  <div class="flex flex-wrap -mx-2">
    <div :key="item" v-for="item in 10" class="w-1/4 px-2">
      <div class="bg-light rounded p-1 mb-2 flex items-center">
        <div class="w-1/3 mr-2 flex items-center justify-center h-12">
          <i class="mdi mdi-folder text-4xl"></i>
        </div>
        <div>
          <p class="font-bold">{{ item }}</p>
          <p class="text-xs">{{ item }}kb</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'MediaManagerContentList'
  }
</script>

<style scoped>

</style>