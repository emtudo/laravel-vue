<script>
import MaskTextField from '../../MaskTextField/MaskTextField'

export default {
  name: 'phone',
  mixins: [MaskTextField],
  props: {
    errors: null,
    mask: { // Mask to input (read format.js)
      type: [String, Array],
      default: () => {
        return [
          {
            min: 1,
            max: 10,
            mask: '## ####-####'
          },
          {
            min: 11,
            max: 11,
            mask: '## # ####-####'
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
