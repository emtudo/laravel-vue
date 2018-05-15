// dependencies.
import flatten from './flatten'
import messages from './messages'
import expiredToken from './expired_token'
import token from './token'

/**
 * Request interceptors.
 *
 * @param http
 * @param store
 * @param router
 */
export default (http, store, router) => {
  // handle http expired token.
  http.interceptors.response.use(expiredToken.success(store), expiredToken.error(store))

  // handle http messages.
  http.interceptors.response.use(messages.success, messages.error)

  // flatten data
  http.interceptors.response.use(flatten.success, flatten.error)

  // set authorization token.
  http.interceptors.request.use(token(store, router), error => error)
}
