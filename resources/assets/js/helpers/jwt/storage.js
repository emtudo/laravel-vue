// dependencies.
// import { factory } from './utils'
import { isEmpty } from 'lodash'
import { get, set } from '@/helpers/storage'

/**
 * Retrieve the token from browser storage.
 */
export const retrieve = () => get('jwt-token') // .then(value => factory(value, true))

/**
 * Store the token into browser storage.
 *
 * @param token
 */
export const store = token => {
  return set('jwt-token', token) // .then((token) => factory(token, true))
}

/**
 * Store or retrieve a token from browser storage.
 *
 * @param token
 */
export const storeOrRetrieve = (token = null) => {
  if (isEmpty(token)) {
    return retrieve()
  } else {
    console.log('isNotEmpty(token)', token)
    return store(token)
  }
}

/**
 * Default export.
 */
export default {
  store,
  retrieve,
  storeOrRetrieve
}
