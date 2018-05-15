/**
 * iziToast Vue.js Plugin.
 */

// import the toast actions.
import ToastPlugin from './toast'

/**
 * Plugin install export.
 * @param Vue
 * @constructor
 */
const ToastInstall = function (Vue) {
  Vue.prototype.$toast = ToastPlugin
}

/**
 * Export that accepts a vue instance.
 * @param Vue
 */
export default (Vue) => {
  Vue.use(ToastInstall)
}
