<script>
import MaskTextField from '../../MaskTextField/MaskTextField'

const mask = max => {
  let text = ''
  for (let i = 0; i < max; i++) {
    text += '#'
  }

  return text
}

export default {
  name: 'number',
  mixins: [MaskTextField],
  props: {
    mask: { // Mask to input (read format.js)
      type: [String, Array],
      default: mask(255)
    }
  }
}
</script>
