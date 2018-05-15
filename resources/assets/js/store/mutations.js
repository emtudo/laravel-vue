/**
 * Global mutations.
 */
// default export.
export default {
  /**
   * Set global user data.
   *
   * @param state
   * @param userData
   */
  setUserData (state, userData) {
    state.user = userData
  },

  /**
   * @param state
   * @param avatar
   */
  setAvatar (state, avatar) {
    state.user.avatar = avatar
  },

  /**
   * Clear user data.
   *
   * @param state
   */
  clearUserData (state) {
    state.user = {
      id: null, // user id.
      name: null, // user name.
      email: null, // user email.
      two_factor: {
        enabled: false,
        valid: false
      }
    }
  },

  /**
   * Set user JWT token into local store.
   *
   * @param state
   * @param jwt
   */
  setJWT (state, jwt) {
    // set raw token data.
    state.jwt = jwt
  },

  setTwoFactorEnable (state, value) {
    state.user.two_factor.enabled = value
  },
  setTwoFactorValid (state, value) {
    state.user.two_factor.valid = value
  }
}
