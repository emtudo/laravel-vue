import localForage from 'localforage'

export const storage = localForage.createInstance({
  name: 'emtudo-skeleton'
})

export const get = item => storage.getItem(item).then(v => Promise.resolve(v))

export const set = (item, value) => storage.setItem(item, value).then(() => get(item))

export const remove = item => storage.removeItem(item)

export const clear = () => storage.clear()

export default {
  get,
  set,
  remove,
  clear
}
