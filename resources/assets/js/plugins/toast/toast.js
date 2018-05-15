/**
 * Vue iziToast plugin.
 */

// import toast.
import iziToast from 'izitoast'

// import lodash's assign.
import { assign } from 'lodash'

/**
 * Plugin export.
 */
export default {

  /**
   * Default iziToast options.
   */
  options: {
    // default position.
    // position: 'topCenter',
    position: 'center',
    // default layout.
    layout: 1,
    zindex: 90000
  },

  /**
   * The stay method creates a config object for a persistent toast.
   *
   * @returns {*}
   */
  stay () {
    return assign({timeout: null, progressBar: false}, this.options)
  },

  /**
   * The leave method creates a config object for a toast the disappears after some time.
   *
   * @returns {*}
   */
  leave (timeout = 2000) {
    return assign({ timeout, progressBar: true }, this.options)
  },

  /**
   * The method that actually fires the toast.
   *
   * @param {String}  type
   * @param {String}  message
   * @param {Object}  config
   * @param {Boolean} stay
   */
  toast (type, message, config, stay) {
    // base options based on stay|hide config.
    const baseOptions = stay ? this.stay() : this.leave()
    // inject the message into the basic configuration.
    const messagedOptions = assign(baseOptions, { message })
    // merge the custom configuration passed by client.
    const finalOptions = assign(messagedOptions, config)

    // launches the toast.
    iziToast[type](finalOptions)
  },

  /**
   * Launches a "info" (blue) styled toast.
   * @param message
   * @param stay
   * @param config
   */
  info (message, stay = false, config = {}) {
    this.toast('info', message, config, stay)
  },

  /**
   * Launches a "success" (green) styled toast.
   * @param message
   * @param stay
   * @param config
   */
  success (message, stay = false, config = {}) {
    this.toast('success', message, config, stay)
  },

  /**
   * Launches a "warning" (yellow) styled toast.
   * @param message
   * @param stay
   * @param config
   */
  warning (message, stay = false, config = {}) {
    this.toast('warning', message, config, stay)
  },

  /**
   * Launches a "error" (red) styled toast.
   * @param message
   * @param stay
   * @param config
   */
  error (message, stay = false, config = {}) {
    this.toast('error', message, config, stay)
  },

  /**
   * Destroy all toasts actively being displayed.
   */
  destroyAll () {
    iziToast.destroy()
  }
}
