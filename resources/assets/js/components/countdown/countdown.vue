<script>
export default {
  name: 'countdown',
  beforeDestroy () {
    clearInterval(this.timeout)
  },
  computed: {
    current () {
      return this.time
    }
  },
  data () {
    return {
      timeout: null,
      time: null
    }
  },
  methods: {
    interval () {
      this.time = this.value
      this.timeout = setInterval(() => {
        this.time--

        if (this.time < 1) {
          clearInterval(this.timeout)
          this.$emit('timeout', true)
        }
      }, 1000)
    }
  },
  mounted () {
    this.interval()
  },
  props: {
    value: {
      type: Number,
      required: true
    }
  }
}
</script>

<template lang="pug">
  span(v-if="time>0")
    | {{ current }}
</template>
