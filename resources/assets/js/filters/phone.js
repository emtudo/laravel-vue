// dependencies.
import { format } from '@/helpers/format'

const defaultMask = [
  {
    min: 11,
    max: 11,
    mask: '## # ####-####'
  },
  {
    min: 10,
    max: 10,
    mask: '## ####-####'
  }
]

export default (phone, mask = defaultMask) => {
  return format(phone, mask)
}
