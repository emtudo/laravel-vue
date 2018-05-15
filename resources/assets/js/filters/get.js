// dependencies.
import { get } from 'lodash'

export default (value, key = null, defaultValue = null) => {
  return get(value, key, defaultValue)
}
