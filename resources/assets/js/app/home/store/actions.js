export default {
  action: ({commit}, value = null) => {
    commit('setAction', value)
  }
}
