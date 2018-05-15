// dependencies.
import countryRegister from './countryRegister'
import phone from './phone'
import showDate from './showDate'

/**
 * Export / install filters.
 * @param Vue
 */
export default (Vue) => {
  Vue.filter('countryRegister', countryRegister)
  Vue.filter('phone', phone)
  Vue.filter('showDate', showDate)
}
