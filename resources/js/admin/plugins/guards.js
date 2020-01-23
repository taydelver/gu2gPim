import store from '../../store'

export default {
  auth: (router) => {
    router.beforeEach((to, from, next) => {
      if(to.matched.some(record => record.meta.noAuth)) {
        next()
      } else {
        if (!store.getters.loggedIn) next('/login')
        
        next()
      }
    })
  }
}