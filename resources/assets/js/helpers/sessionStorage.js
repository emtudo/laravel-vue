const storage = window.sessionStorage

export const get = (item, defaultValue = null) => {
  const value = storage.getItem(item)
  if (!value || value === undefined) {
    return defaultValue
  }

  return JSON.parse(value)
}

export const set = (item, value) => storage.setItem(item, JSON.stringify(value))

export const remove = item => storage.removeItem(item)

export default {
  get,
  set,
  remove
}
