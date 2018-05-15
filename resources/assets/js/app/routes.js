import { routes as auth } from './auth'
import { routes as home } from './home'
import { routes as perfil } from './perfil'
import { routes as users } from './users'

export default [
  ...auth,
  ...home,
  ...perfil,
  ...users
]
