import { get } from 'lodash'

export const twoFactor = ({ user }) => get(user, 'two_factor', null)
export const twoFactorIsActive = ({ user }) => get(user, 'two_factor.enabled', false)
export const twoFactorIsValid = ({ user }) => {
  const enabled = get(user, 'two_factor.enabled', false)
  if (!enabled) {
    return true
  }

  return get(user, 'two_factor.valid', false)
}
