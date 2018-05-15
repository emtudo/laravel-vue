<script>
import { format } from '@/helpers/format'
import Error from '../Helpers/error.vue'
import { isEmpty } from 'lodash'

const keyValids = [
  'Control',
  'Enter',
  'Tab',
  'Delete',
  'Backspace',
  'Home',
  'End',
  'ArrowDown',
  'ArrowUp',
  'ArrowLeft',
  'ArrowRight'
]

const copyCutOrPast = (event) => {
  return (['KeyC', 'KeyX', 'KeyV'].includes(event.code) && event.ctrlKey)
}

export default {
  name: 'mask_text_field',
  components: {
    Error
  },
  data () {
    return {
      valueInput: ''
    }
  },
  props: {
    errors: null,
    disabled: {
      type: Boolean,
      default: false
    },
    name: {
      type: String,
      default: ''
    },
    label: {
      type: String,
      default: null
    },
    placeholder: {
      type: String,
      default: null
    },
    value: { // Default value
      type: String,
      default: null
    },
    mask: { // Mask to input (read format.js)
      type: [String, Array],
      required: true
    },
    maxlength: { // Maxlength without mask
      type: Number,
      default: 255
    }
  },
  methods: {
    // Formats when keydown
    keydown (event) {
      const isNumber = new RegExp(/[0-9]/g)
      if (!(keyValids.includes(event.key)) && !isNumber.exec(event.key)) {
        if (!copyCutOrPast(event)) {
          event.preventDefault()
        }
      } else if (!this.acceptKey(event) && !keyValids.includes(event.key)) {
        event.preventDefault()
      }
    },
    acceptKey (event) {
      return true
    },
    // Formats when keyup
    keyup (event) {
      event.preventDefault()
      if (isEmpty(this.valueInput)) {
        return
      }
      this.valueInput = format(this.valueInput.replace(/[^0-9]+/g, ''), this.mask)

      if (event.key === 'Enter') {
        this.$emit('keyup', event)
      }
    },
    // Call event when changes
    change (event) {
      event.preventDefault()
      const value = (this.clear) ? this.valueInput.replace(/[^0-9]+/g, '') : this.valueInput

      this.$emit('input', value)
      this.$emit('change', value)

      this.afterChange(value)
    },
    afterChange (value) {
    }
  },
  mounted () {
    this.valueInput = format(this.value, this.mask)
  },
  watch: {
    'valueInput' (value) {
      this.$emit('input', value)
    }
  }
}
</script>

<template lang="pug">
div(:class="{invalid: errors}")
  input.form-control(
    :disabled="disabled",
    :placeholder="placeholder",
    type="text",
    :name="name",
    :id="name",
    v-model="valueInput",
    :maxlength="maxlength",
    @keydown="keydown",
    @keyup="keyup",
    @change="change"
    )
  label(:for="name" :class="{active: valueInput}" v-if="valueInput") {{ label || placeholder}}
  error(:message="errors")
</template>
