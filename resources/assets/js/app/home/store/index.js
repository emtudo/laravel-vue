import * as getters from './getters' // getters.
import state from './state' // state.
import actions from './actions' // actions.
import mutations from './mutations' // mutations.

/**
 * Export store resources.
 */
export default {
  namespaced: true, // make sure the module store gets it's own namespace.
  state,
  actions,
  getters,
  mutations
}
