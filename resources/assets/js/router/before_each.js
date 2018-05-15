import store from '@/store'
import { get } from 'lodash'
import toast from '@/plugins/toast/toast'

const requireTwoFactor = route => {
  return get(route, 'meta.twoFactor', false)
}

const routeIsAuthTwoFactor = route => {
  return get(route, 'name', null) === 'auth.two_factor'
}

/**
 * check if user has permission
 *
 * @param Object user
 * @param String route
 *
 * @return Boolean
 */
const hasRole = (user, route) => {
  const role = get(route, 'meta.role', 'admin')
  if (role === 'guest') {
    return true
  }

  return user.is_admin
}

/**
 * Runs before each route change.
 *
 * @param to
 * @param from
 * @param next
 */
const beforeEach = (to, from, next) => {
  // setup page title (not vue handled).
  document.title = get(to, 'meta.title', 'Emtudo Skeleton')

  if (!get(to, 'meta.auth', true)) {
    const force = get(to, 'meta.forceSetupUser', false)
    if (force) {
      store.dispatch('setupUserSilent')
    }
    return next()
  }

  // dispatch the user info actions and continue the request after.
  return store.dispatch('setupUser')
    .then((user) => {
      if (routeIsAuthTwoFactor(to)) {
        return next()
      }
      const twoFactor = user['two_factor']
      if (!hasRole(user, to)) {
        toast.warning('Você não tem permissão para acessar esta rota!')
        return
      }
      if (requireTwoFactor(to) && twoFactor.enabled && !twoFactor.valid) {
        return next({name: 'auth.two_factor'})
      }
      return next()
    })
    .catch(() => {
      return next({name: 'auth.login'})
    })
}

export default beforeEach
