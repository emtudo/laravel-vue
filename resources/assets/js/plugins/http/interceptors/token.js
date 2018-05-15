// dependencies.
import { curry, toString, get, isEmpty } from 'lodash'

const bypassHeader = url => url.indexOf('auth/login') !== -1 ||
  url.indexOf('auth/register') !== -1 ||
  url.indexOf('auth/password/email') !== -1 ||
  url.indexOf('auth/password/reset') !== -1

const bypassSetup = url => url.indexOf('auth/user') !== -1 || url.indexOf('auth/refresh') !== -1
const getToken = store => get(store, 'getters.jwt', null)
const getHeader = (request, store) => {
  const token = getToken(store)
  return isEmpty(token) ? null : `Bearer ${token}`
}

/**
 * Authorization / Token interceptor.
 */
export default curry((store, router, request) => {
  // request url as string.
  const url = toString(request.url)

  // should a authorization header be used?
  if (bypassHeader(url)) {
    return request
  }

  // is a setup needed?
  if (bypassSetup(url)) {
    request.headers.Authorization = getHeader(request, store)
    return request
  }

  // dispatch the JWT setup action
  return store.dispatch('setupJWT').then(() => {
    request.headers.Authorization = getHeader(request, store)
    return request
  }).catch(() => {
    return request
  })
})
