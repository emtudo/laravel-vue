<script>
import MaskTextField from '../../MaskTextField/MaskTextField'

export default {
  name: 'landline',
  mixins: [MaskTextField],
  props: {
    errors: null,
    mask: { // Mask to input (read format.js)
      type: [String, Array],
      default: () => {
        return [
          {
            min: 10,
            max: 10,
            mask: '## ####-####'
          }
        ]
      }
    },
    maxlength: { // Maxlength without mask
      type: Number,
      default: 12
    }
  }
}
</script>
