<script>
import bus from '../../eventBus'
export default {
  name: 'alerts',
  data () {
    return {
      success: true,
      message: null,
      className: 'alert-success'
    }
  },
  mounted () {
    bus.$on('success', message => {
      this.className = 'alert-success'
      this.success = true
      this.message = message
    })
    bus.$on('danger', message => {
      this.className = 'alert-danger'
      this.success = false
      this.message = message
    })
  }
}
</script>

<template>
  <div class="alert" v-if="message" :class="className" v-html="message">
  </div>
</template>
