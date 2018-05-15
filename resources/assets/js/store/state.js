/**
 * Global vuex state.
 */
// default export.
export default {
  remember: true,

  /**
   * JWT Token and Data.
   */
  jwt: {
    token: null
  },

  /**
   * Basic user information.
   */
  user: {
    id: null, // user id.
    name: null, // user name.
    email: null, // user email.
    two_factor: {
      enabled: false,
      valid: false
    }
  }
}
