import isMobile from '@/helpers/isMobile'

export default function install (Vue) {
  // define $http into vue prototype.
  Object.defineProperty(Vue.prototype, '$isMobile', {
    get () {
      return isMobile()
    }
  })
}
