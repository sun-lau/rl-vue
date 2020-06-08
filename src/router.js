import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

let router = new Router({
  routes: [
    {
      path: '/',
      name: 'base',
      component: () => import('./views/Home.vue')
    },
    {
      path: '/home',
      name: 'home',
      component: () => import('./views/Home.vue')
    },
    {
      path: '/about',
      name: 'about',
      component: () => import('./views/About.vue')
    },
    {
      path: '/concept',
      name: 'concept',
      component: () => import('./views/Concept.vue')
    },
    {
      path: '/news',
      name: 'news',
      component: () => import('./views/News.vue')
    },
    {
      path: '/booking/:experiment_name',
      name: 'booking',
      component: () => import('./views/Booking.vue'),
      meta: { 
          requiresAuth: true
      }
    },
    {
      path: '/experiment/interference',
      name: 'experiment_interference',
      component: () => import('./views/Experiments/Interference.vue')
    },
    {
      path: '/experiment/apparent_depth',
      name: 'experiment_apparent_depth',
      component: () => import('./views/Experiments/ApparentDepth.vue')
    },
    {
      path: '/experiment/visible_spectrum',
      name: 'experiment_visible_spectrum',
      component: () => import('./views/Experiments/VisibleSpectrum.vue')
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('./views/Login.vue')
    },
    {
      path: '/logout',
      name: 'logout',
      component: () => import('./views/Logout.vue')
    },
    {
      path: '/admin',
      name: 'admin',
      component: () => import('./views/Admin.vue')
    }
  ]
})

router.beforeEach((to, from, next) => {
  if(to.matched.some(record => record.meta.requiresAuth)) {
      if ($cookies.get('auth_token') == null) {
        // $cookies.set('after_login', to.fullPath);
          next({
              path: '/login',
              params: { nextUrl: to.fullPath }
          })
      } else {
          // let user = JSON.parse(localStorage.getItem('user'))
          // if(to.matched.some(record => record.meta.is_admin)) {
          //     if(user.is_admin == 1){
          //         next()
          //     }
          //     else{
          //         next({ name: 'userboard'})
          //     }
          // }else {
              next()
          // }
      }
  } 
  else {
      next() 
  }
})

export default router
