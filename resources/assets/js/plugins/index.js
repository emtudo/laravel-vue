// import plugins
import http from './http'
import Toast from './toast'
import IsMobile from './is_mobile'

/**
 * Default export.
 *
 * @param Vue
 * @param router
 */
export default (Vue, { store, router }) => {
  // setup http
  Vue.use(http, { store, router })

  // setup toast
  Toast(Vue)

  Vue.use(IsMobile)
}
