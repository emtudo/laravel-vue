<script>
import MaskTextField from '../../MaskTextField/MaskTextField'
import { isEmpty, get } from 'lodash'
import axios from 'axios'

export default {
  name: 'zip',
  mixins: [MaskTextField],
  methods: {
    emitClean () {
      this.$emit('on-get-address', {
        street: null,
        district: null,
        city: null,
        state: null
      })
    },
    afterChange (value) {
      if (isEmpty(value)) {
        this.emitClean()
        return
      }

      const zip = value.replace(/[^0-9]/, '')

      axios.get(`https://viacep.com.br/ws/${zip}/json/`)
        .then(({data}) => {
          if (get(data, 'erro', false)) {
            this.emitClean()
            return
          }
          this.$emit('on-get-address', {
            street: data.logradouro,
            district: data.bairro,
            city: data.localidade,
            state: data.uf
          })
        })
        .catch((er) => {
          this.emitClean()
        })
    }
  },
  props: {
    mask: { // Mask to input (read format.js)
      type: [String, Array],
      default: () => {
        return [
          {
            mask: '##.###-###'
          }
        ]
      }
    },
    maxlength: { // Maxlength without mask
      type: Number,
      default: 10
    }
  }
}
</script>
