<script>
import MaskTextField from '../../MaskTextField/MaskTextField'

export default {
  name: 'document-cpf',
  mixins: [MaskTextField],
  props: {
    forceLabel: {
      type: Boolean,
      default: true
    },
    errors: null,
    disabled: {
      type: Boolean,
      default: false
    },
    mask: { // Mask to input (read format.js)
      type: [String, Array],
      default: () => {
        return [
          {
            mask: '###.###.###-##'
          }
        ]
      }
    },
    maxlength: { // Maxlength without mask
      type: Number,
      default: 14
    }
  }
}
</script>
