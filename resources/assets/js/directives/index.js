import { run as inserted, run as update } from './helpers'
import visible from './visible'

/**
 * Export / install custom directives.
 *
 * @param Vue
 */
export default (Vue) => {
  /**
   * How to use focus, select, visible:
   * v-select or:
   * v-select :data-v-select="true"
   *
   * v-focus or:
   * v-focus :data-v-focus="1 === 0"
   *
   * v-visible or:
   * v-visible data-v-visible="true"
   */
  Vue.directive('focus', {inserted, update})
  Vue.directive('select', {inserted, update})
  Vue.directive('visible', visible)
}
