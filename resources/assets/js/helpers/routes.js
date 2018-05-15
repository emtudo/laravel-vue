// dependencies.
import { map, assign, toString } from 'lodash'
const defaultTitle = 'Emtudo - Skeleton'

export const metaAdmin = (title = defaultTitle, auth = true, twoFactor = true, role = 'admin', kind = 'page') => {
  return meta(title, auth, twoFactor, role, kind)
}

export const metaForceSetupUser = (title = defaultTitle, auth = true, twoFactor = true, role = 'guest', kind = 'page') => {
  return {
    ...meta(title, auth, twoFactor, role, kind),
    forceSetupUser: true
  }
}

export const meta = (title = defaultTitle, auth = true, twoFactor = true, role = 'guest', kind = 'page') => {
  let headerTitle = title
  if (title !== defaultTitle) {
    title = title + ' - ' + defaultTitle
  } else {
    headerTitle = 'Skeleton'
  }

  return {
    auth,
    twoFactor,
    role,
    title,
    headerTitle,
    kind
  }
}

/**
* Generates a route object from some given parameters.
*
* @param {String} name
* @param {String} path
* @param {Object} component
* @param {Object} defaultMeta
* @returns {{name: *, path: *, component: *, meta: *}}
*/
export const route = (name, path, component, defaultMeta = meta()) => {
  return assign({}, { name, path: path, component, meta: defaultMeta })
}

/**
* Generates a subGroup object from some given parameters.
*
* @param {String} pathPrefix
* @param {Array} routes
* @returns {Array} routes
*/
export const subGroup = (pathPrefix, routes) => {
  return map(routes, (route) => {
    return prepareRoute(route, pathPrefix, urlToName(pathPrefix), route.meta)
  })
}

/**
* Generates a route name from a given url.
*
* @param url
* @returns {string}
*/
export const urlToName = url => {
  return toString(url)
    .replace(/^(\/?)app/, '') // remove /app from the beginning of the path.
    .replace(new RegExp('/', 'g'), '.') // replace all / (slash) with . (dot)
    .replace(/^\./, '') // remove . (dot) from the beginning of the path.
}

/**
* Prepend name and path prefixes into a route object.
*
* @param {Object} r { route }
* @param {String} pathPrefix
* @param {String} namePrefix
* @param {Object} meta
* @returns {Object}
*/
export const prepareRoute = (r, pathPrefix, namePrefix, meta) => {
  r.name = namePrefix ? namePrefix + `.${r.name}` : r.name
  r.path = r.path ? `${pathPrefix}${r.path}` : pathPrefix
  r.meta = {...r.meta, ...meta}

  return {...r}
}

/**
* Prepares an array of routes with given prefixes and default configurations.
*
* @param pathPrefix
* @param routes
* @param meta
* @returns {Array}
*/
export const group = (pathPrefix, routes = [], meta = { auth: true }) => {
  return map(routes, r => prepareRoute(r, pathPrefix, urlToName(pathPrefix), meta))
}

/**
* Prepares an array of routes with given prefixes and default configurations.
*
* @param pathPrefix
* @param routes
* @param meta
* @returns {Array}
*/
export const groupGuest = (pathPrefix, routes = [], meta = { auth: false }) => {
  return map(routes, r => prepareRoute(r, pathPrefix, urlToName(pathPrefix), meta))
}

/**
* Prepares an array of routes with given prefixes and default configurations.
*
* @param pathPrefix
* @param routes
* @param meta
* @returns {Array}
*/
export const groupAdmin = (pathPrefix, routes = [], meta = {}) => {
  return group(pathPrefix, routes, {...meta, auth: true, role: 'admin'})
}
