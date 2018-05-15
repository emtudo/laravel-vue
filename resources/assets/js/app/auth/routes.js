import { route, meta } from '@/helpers/routes'
import ResetEmail from './reset/email'
import ResetPassword from './reset/password'
import Login from './login/login'
import TwoFactor from './login/two-factor'
import Register from './register/register'

export default [
  route('auth.login', '/auth/login', Login, meta('Login', false, false)),
  route('auth.register', '/auth/register', Register, meta('Registrar usuário', false, false)),
  route('auth.password.email', '/auth/password/email', ResetEmail, meta('Recuperar senha', false, false)),
  route('auth.password.reset', '/auth/password/reset/:token', ResetPassword, meta('Recuperar senha', false, false)),
  route('auth.two_factor', '/auth/two_factor', TwoFactor, meta('Ativar Two Factor', true, false))
]
