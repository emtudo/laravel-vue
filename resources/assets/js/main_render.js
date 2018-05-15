import Vue from 'vue'
import router from './router'
import GlobalComponents from './components'
import Plugins from './plugins'
import store from './store'
import Filters from './filters'
import Directives from './directives'
import App from './layout/app'

GlobalComponents(Vue)
Plugins(Vue, {store, router})
require('./bootstrap')
Directives(Vue)
Filters(Vue)

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  render: h => h(App)
})
