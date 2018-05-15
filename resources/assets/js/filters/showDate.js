// dependencies.
import moment from 'moment'

export default (date, format = 'DD/MM/YYYY', original = 'YYYY/MM/DD') => {
  if (date === null) {
    return date
  }

  return moment(date, original).format(format)
}
