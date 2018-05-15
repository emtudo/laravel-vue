// Vue
import Vue from 'vue'
// import the vue-router
import VueRouter from 'vue-router'

// import application routes
import { routes as app } from '@/app'

// run before each route change
import beforeEach from './before_each'
import forceHttps from './force_https'
forceHttps()

// make vue-router available on Vue
Vue.use(VueRouter)

// spread app routes
const routes = [...app]

// create a new router instance.
const router = new VueRouter({
  routes,
  linkActiveClass: 'active'
})

// setup a before each for routes.
router.beforeEach(beforeEach)

// return the router on the default export.
export default router
