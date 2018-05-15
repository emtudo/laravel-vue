import Form from './form'
import Masked from './masked'

export default (Vue) => {
  Form(Vue)
  Masked(Vue)
  Vue.component('alerts', () => import('./alerts/alerts'))
  Vue.component('countdown', () => import('./countdown/countdown'))
  Vue.component('page', () => import('./page/page'))
}
