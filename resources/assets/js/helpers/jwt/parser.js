// import { isEmpty } from 'lodash'
import { storeOrRetrieve } from './storage'
import sessionStorage from '@/helpers/sessionStorage'
import { http } from '@/plugins/http'
import { refreshable, expired, factory } from './utils'

/**
 * Method that loads the JWT from local storage.
 * @returns {Promise}
 */
// export const loadTokenFromLocalStorage = () => {
//   const token = storage.retrieve()
//
//   return expired(token) ? null : token
// }

export const refreshToken = token => {
  // if not expired, no need for refresh.
  if (!expired(token)) { return Promise.resolve(token) }
  // if expired but after refresh limit, just reject.
  if (!refreshable(token)) {
    sessionStorage.remove('token')
    sessionStorage.remove('user')

    return Promise.reject(new Error('TOKEN_NOT_REFRESHABLE'))
  }

  // otherwise, made the refresh request.
  return http.post('/auth/refresh', { token: token.token })
    .then(({ data }) => Promise.resolve(storeOrRetrieve(factory(data.token))))
}

export const loadToken = (tokenString = null) => {
  // create a token variable
  return storeOrRetrieve(tokenString ? factory(tokenString) : null)
    .then(token => refreshToken(token))
}

// export default loadToken
