<script>
import Error from '../Helpers/error'

/**
 * Text Field Component.
 */
export default {
  // component name.
  name: 'f-text',

  components: {
    Error
  },

  data () {
    return {
      internalValue: null
    }
  },

  methods: {
    /**
   * Emit the input event for the parent component.
   *
   */
    updateValue: function (event) {
      this.$emit('input', event.target.value)
      this.$emit('change', event.target.value)
    }
  },

  // custom component props
  props: {
    error: {
      default: null
    },
    name: {
      type: String,
      required: true
    },
    /**
      * Text-Link input types can use the same component.
      * i.e email, password, etc.
      */
    type: {
      type: String,
      default: 'text'
    },
    className: {
      type: Array,
      default: () => { [] }
    },
    disabled: {
      type: Boolean,
      default: false
    },
    maxlength: {
      type: Number,
      default: 255
    },
    required: {
      type: Boolean,
      default: false
    },

    /**
     * Field label.
     */
    label: {
      type: String,
      default: null
    },

    /**
     * Field placeholder, should be omitted for normal fields.
     * Only use this when with a select.
     */
    placeholder: {
      type: String,
      default: null
    },

    /**
     * Input value.
     */
    value: {
      default: () => {
      }
    }
  }
}
</script>

<template lang="pug">
  div(:class="className")
    label.form-label.text-md-right(:for="name")
      template(v-if="value")
        | {{ label }}
      template(v-if="!value")
        | &nbsp;
    input.form-control(
      :disabled="disabled",
      :placeholder="placeholder || label",
      :type="type",
      :name="name",
      :id="name",
      :maxlength="maxlength",
      :class="{'is-invalid': error}"
      :value="value",
      :required="required",
      @input="updateValue")
    error(:message="error")
</template>
