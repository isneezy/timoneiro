<template>
  <div class="fixed right-0 z-50 mr-4" style="top: 5rem">
    <transition-group name="list">
      <toast
        v-for="notification in notifications"
        :key="notification.id"
        :notification="notification"
        @close="close(notification)"
      />
    </transition-group>
  </div>
</template>

<script>
  import { ref, computed } from '@vue/composition-api'
  import Toast from './Toast'
  import { onNotify } from '../../helpers'

  export default {
    name: 'ToastNotifications',
    components: { Toast },
    setup() {
      const items = ref([])

      onNotify(pushNotification => {
        items.value.push(pushNotification)
      })

      const notifications = computed(() => {
        return items.value.slice().reverse()
      })

      function close(notification) {
        items.value = items.value.filter(item => item.id !== notification.id)
      }

      return { notifications, close }
    }
  }
</script>

<style scoped>
  .list-enter-active,
  .list-leave-active {
    transition: all 0.5s;
  }
  .list-enter,
  .list-leave-to {
    opacity: 0;
    transform: translateX(20px);
  }
  .list-move {
    transition: transform 0.5s;
  }
</style>
