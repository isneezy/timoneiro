<template>
  <div :id="`toast-${notification.id}`" class="w-42 relative card bg-white shadow rounded p-5 mb-2">
    <div class="card-body no-gutters row" :class="className">
      <div class="col-2 align-self-center text-center text-success">
        <!--<Icon :icon="icon" :class="className" />-->
      </div>
      <div class="col-10 row no-gutters">
        <div class="col-12 text-bold mt-1">
          {{ notification.title }}
        </div>
        <div class="col-12 text-muted mb-1">
          {{ notification.message }}
        </div>
      </div>
      <div class="close" @click="close">
        <!--<Icon icon="close" />-->
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
    setup(props) {
      let timer = null
      const className = computed(() => {
        const className = {}
        className[`toast-${props.notification.variant}`] = !!props.notification
          .variant
        className[`text-${props.notification.variant}`] = !!props.notification
          .variant
        return className
      })

      function close() {
        this.$emit('close')
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

<!--<style lang="scss" scoped>-->
  <!--@import '~assets/scss/design';-->
  <!--.card {-->
    <!--border: none;-->
    <!--width: 20rem;-->
    <!--position: relative;-->
    <!--.card-body {-->
      <!--padding: 0.4rem;-->
      <!--&.toast-success {-->
        <!--border-left: 6px solid $success;-->
      <!--}-->
      <!--&.toast-warning {-->
        <!--border-left: 6px solid $warning;-->
      <!--}-->
      <!--&.toast-info {-->
        <!--border-left: 6px solid $info;-->
      <!--}-->
      <!--&.toast-danger {-->
        <!--border-left: 6px solid $danger;-->
      <!--}-->
      <!--.close {-->
        <!--position: absolute;-->
        <!--top: 0.2rem;-->
        <!--right: 0.5rem;-->
        <!--cursor: pointer;-->
        <!--font-size: 1rem;-->
        <!--width: 50px;-->
        <!--text-align: center;-->
      <!--}-->
    <!--}-->
  <!--}-->
<!--</style>-->
