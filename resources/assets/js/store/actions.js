/**
 * Global vuex actions.
 */
import { http } from '@/plugins/http'
import toast from '@/plugins/toast/toast'
import { get } from 'lodash'
import { get as find, set, clear } from '@/helpers/storage'
import sessionStorage from '@/helpers/sessionStorage'

const setToken = (commit, token) => {
  commit('setJWT', token)
  sessionStorage.set('token', token)
  if (sessionStorage.get('remember')) {
    set('token', token)
  }
}

const setUser = (commit, user) => {
  commit('setUserData', user)
  sessionStorage.set('user', user)
}

const nullToken = () => {
  // window.location.href = '/dashboard/auth'
  if (showToast) {
    toast.error('Problemas na sua sessão, logue novamente!')
  }
}

let showToast = true

export default {
  setupJWT: ({ commit, getters, dispatch }, tokenString = null) => {
    // if no token was passed, get it from the store.
    const currentToken = tokenString || get(getters.jwt, 'token') || sessionStorage.get('token')

    if (currentToken) {
      setToken(commit, currentToken)

      return Promise.resolve(currentToken)
    }

    return find('token') // load the token
      .then((token) => {
        if (token === null) {
          return nullToken()
        }
        sessionStorage.set('remember', true)
        setToken(commit, token)

        return token
      }).catch((data) => {
        return nullToken()
      })
  },

  updateUserData: ({commit}, user) => {
    setUser(commit, user)

    return user
  },

  activeTwoFactor: ({commit, getters}, value = true) => {
    const user = {...getters.user}
    user.two_factor = {
      ...user.two_factor,
      enabled: value
    }
    setUser(commit, user)
  },

  disabledTwoFactor: ({commit, getters}) => {
    return http.get('/auth/two_factor/disabled')
      .then(({data}) => {
        setToken(commit, data.token)
        setUser(commit, data.user)

        return data
      })
      .catch(({data}) => {
        return Promise.reject(data)
      })
  },

  updateTwoFactorValid: ({commit, getters}, value = true) => {
    const user = {...getters.user}
    user.two_factor = {
      ...user.two_factor,
      valid: value
    }
    setUser(commit, user)
  },

  refreshToken: ({commit}) => {
    return http.post('auth/refresh')
      .then(({data}) => {
        setToken(commit, data.token)
        return data.token
      })
      .catch(({data}) => {
        toast.error('Você não tem acesso, ou sua sessão está expirada, logue novamente!')
      })
  },

  logout: ({ commit }) => {
    showToast = false
    sessionStorage.remove('token')
    sessionStorage.remove('user')
    sessionStorage.remove('remember')
    commit('clearUserData')
    commit('setJWT', null)

    return clear()
  },

  setupUserSilent: ({ dispatch }) => {
    showToast = false
    return dispatch('setupUser')
  },

  setupUser: ({ getters, dispatch, commit }) => {
    return dispatch('setupJWT').then(() => {
      const currentUser = sessionStorage.get('user')
      if (currentUser && currentUser !== undefined) {
        setUser(commit, currentUser)
        return Promise.resolve(currentUser)
      }
      return http.get('/auth/user')
        .then(({data}) => {
          setUser(commit, data)

          return data
        })
    }).catch(() => {
    })
  }
}
