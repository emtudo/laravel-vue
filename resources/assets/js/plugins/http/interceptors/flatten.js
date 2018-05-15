import { get } from 'lodash'

/**
 * Flatten success responses body.
 *
 * @param response
 * @returns {*}
 */
export const success = response => get(response, 'data', {})

/**
 * Flatten error responses body.
 *
 * @param error
 * @returns {*}
 */
export const error = error => Promise.reject(get(error, 'response.data', {}))

/**
 * Default export.
 */
export default {
  success,
  error
}
