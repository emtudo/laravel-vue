import moment from 'moment'

export const dateToShow = date => {
  return moment(date).format('DD/MM/YYYY')
}

export const dateToMysql = date => {
  return moment(date, 'DD/MM/YYYY').format('YYYY-MM-DD')
}
