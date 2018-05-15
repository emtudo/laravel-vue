import * as user from './user'
import * as jwt from './jwt'
import * as twoFactor from './two_factor'

export default {
  ...user,
  ...jwt,
  ...twoFactor
}
