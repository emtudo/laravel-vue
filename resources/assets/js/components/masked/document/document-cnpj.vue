<script>
import MaskTextField from '../../MaskTextField/MaskTextField'

export default {
  name: 'document-cnpj',
  mixins: [MaskTextField],
  props: {
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
            mask: '##.###.###/####-##'
          }
        ]
      }
    },
    maxlength: { // Maxlength without mask
      type: Number,
      default: 18
    }
  }
}
</script>
