<script>
import MaskTextField from '../../MaskTextField/MaskTextField'
import { isEmpty } from 'lodash'

export default {
  name: 'phone',
  mixins: [MaskTextField],
  methods: {
    acceptKey (event) {
      if (event.key !== '9' && (!isEmpty(this.valueInput) && this.valueInput.toString().length === 2)) {
        return false
      }

      return true
    }
  },
  props: {
    errors: null,
    mask: { // Mask to input (read format.js)
      type: [String, Array],
      default: () => {
        return [
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
