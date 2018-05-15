// dependencies.
import actions from './actions'

/**
 * Define HTTP resource actions on vue prototype.
 *
 * @param Vue
 */
export default (Vue) => {
  /**
   * register resources as a mixin.
   */
  Vue.mixin({

    /**
     * Created hook.
     */
    created () {
      // get the resource path.
      const { resourcePath } = this.$options

      // if present...
      if (resourcePath !== undefined) {
        // setup the resource into the component.
        this.$setupResource(resourcePath)
      }
    },

    /**
     * Mixin methods
     */
    methods: {
      /**
       * Setup the $resource into component.
       * @param basePath
       */
      $setupResource (basePath) {
        this.$resource = actions(this, basePath)
      }
    }
  })
}
