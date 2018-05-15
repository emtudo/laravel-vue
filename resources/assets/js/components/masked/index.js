export default (Vue) => {
  Vue.component('f-number', () => import('./number/number'))
  Vue.component('f-date', () => import('./date/date'))
  Vue.component('f-cnpj', () => import('./document/document-cnpj'))
  Vue.component('f-cpf', () => import('./document/document-cpf'))
  Vue.component('f-zip', () => import('./zip/zip'))
  Vue.component('f-mobile', () => import('./phone/mobile'))
  Vue.component('f-phone', () => import('./phone/phone'))
  Vue.component('f-landline', () => import('./phone/landline'))
}
