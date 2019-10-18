<template>
  <div :id="`toast-${notification.id}`" class="w-64 relative card bg-white shadow rounded mb-2 overflow-hidden">
    <div class="flex items-center border-l-4 px-4 py-2 pl-0" :class="className">
      <div class="w-10 text-center text-xl">
        <i class="mdi mdi-check"></i>
      </div>
      <div class="flex-1">
        <h5 class="font-bold text-dark">
          {{ notification.title }}
        </h5>
        <div class="text-secondary">
          {{ notification.message }}
        </div>
      </div>
      <div class="absolute top-0 right-0 h-8 w-8 flex items-center justify-center cursor-pointer text-base text-danger" @click="close">
        <i class="mdi mdi-close"></i>
      </div>
    </div>
  </div>
</template>

<script>
  import { computed, onMounted, onBeforeUnmount } from '@vue/composition-api'
  export default {
    name: 'Toast',
    props: {
      notification: {
        required: true,
        type: Object
      }
    },
    setup(props, { emit }) {
      let timer = null
      const className = computed(() => {
        const className = {}
        className[`border-${props.notification.variant}`] = true
        className[`text-${props.notification.variant}`] = true
        return className
      })

      function close() {
        emit('close')
      }

      onMounted(() => {
        timer = props.notification.timeOut
          ? window.setTimeout(close, props.notification.timeOut)
          : false
      })

      onBeforeUnmount(() => {
        if (timer) window.clearTimeout(timer)
      })

      return { className, close }
    }
  }
</script>