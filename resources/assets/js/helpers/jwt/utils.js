import jwtDecode from 'jwt-decode'
import moment from 'moment'
import { isEmpty, get } from 'lodash'

export const decode = tokenString => !isEmpty(tokenString) ? jwtDecode(tokenString) : null

export const factory = (tokenString, stored = false) => {
  if (isEmpty(tokenString)) {
    return null
  }

  let token = null
  try {
    token = decode(tokenString)
  } catch (e) {
    // not possible to parse token.
  }

  if (isEmpty(token)) {
    return null
  }

  return { token: tokenString, data: token, stored }
}

export const usable = token => {
  return !isEmpty(token) && !!get(token, 'data.exp')
}

export const valid = token => usable(token) && moment.unix(get(token, 'data.exp')).isAfter()

export const expired = token => !valid(token)

export const refreshable = token => {
  // a not usable token should not be accepted.
  if (!usable(token)) {
    return false
  }

  // a not expired token is always refreshable.
  if (!expired(token)) {
    return true
  }

  // get the refresh limit from the token, defaults to @hernandev's birthday on the 90's
  const refreshLimit = get(token, 'data.rli', 634780800)

  // return true if the refresh limit is in the future.
  return moment.unix(refreshLimit).isAfter()
}
