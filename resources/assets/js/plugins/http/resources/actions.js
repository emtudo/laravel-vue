// dependencies.
import { isEmpty, isNumber, size, toString } from 'lodash'
import { stringify } from 'qs' // https://github.com/tj/node-querystring

/**
 * Define the query path.
 *
 * @param path
 * @param data
 * @returns {*}
 */
const getQuery = (path, data) => {
  path = valueToString(path)

  // if no query, just return.
  if (size(data) < 1) { return path }

  // encode the query.
  const query = stringify(data)

  // define the separator to use.
  const separator = toString(path).indexOf('?') === -1 ? '?' : '&'

  // return the correct path.
  return path + separator + query
}

const valueToString = (value) => {
  if (isEmpty(value) && !isNumber(value)) {
    return ''
  }

  return value.toString()
}

const completePath = (basePath, path) => {
  const lastChar = valueToString(basePath).charAt(basePath.length - 1)
  const firstChar = valueToString(path).charAt(0)
  const hasBar = (lastChar === '/') || (firstChar === '/')

  if (hasBar || (isEmpty(path) && !isNumber(path))) {
    return `${basePath}${path}`
  }

  return `${basePath}/${path}`
}

/**
 * HTTP resource actions.
 *
 * @param $http
 * @param basePath
 */
export default ({$http}, basePath) => ({
  /**
   * Get.
   * @param path
   * @param data
   * @param config
   *
   * @returns {*}
   */
  get: (path = '', data = {}, config = {}) => {
    path = getQuery(path, data)
    const fullPath = completePath(basePath, path)

    return $http.get(fullPath, config)
  },

  /**
   * Find.
   * @param id
   * @param data
   * @param config
   *
   * @returns {*}
   */
  find: (id, data = {}, config = {}) => {
    const path = getQuery(id, data)

    return $http.get(completePath(basePath, path), config)
  },

  /**
   * Post.
   *
   * @param path
   * @param data
   * @param config
   */
  post: (path = '', data = {}, config = {}) => $http.post(completePath(basePath, path), data, config),

  /**
   * Store.
   *
   * @param data
   * @param config
   */
  store: (data = {}, config = {}) => $http.post(`${basePath}`, data, config),

  /**
   * Update.
   *
   * @param path
   * @param data
   * @param config
   */
  update: (path = '', data = {}, config = {}) => $http.put(completePath(basePath, path), data, config),
  put: (path = '', data = {}, config = {}) => $http.put(completePath(basePath, path), data, config),

  /**
   * Delete.
   *
   * @param path
   * @param data
   * @param config
   */
  delete: (path = '', data = {}, config = {}) => {
    path = getQuery(path, data)

    return $http.delete(completePath(basePath, path), config)
  },

  /**
   * Save.
   *
   * @param data
   * @param config
   * @returns {*}
   */
  save (data = {}, config = {}) {
    if (!isEmpty(data.id) || isNumber(data.id)) {
      return this.update(data.id, data, config)
    }

    return this.store(data, config)
  }
})
