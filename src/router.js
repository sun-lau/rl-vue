import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import Experiment from './views/Experiment.vue'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import('./views/About.vue')
    },
    {
      path: '/experiment',
      name: 'experiment',
      component: Experiment
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
      path: '/login',
      name: 'login',
      component: () => import('./views/Login.vue')
    },
    {
      path: '/logout',
      name: 'logout',
      component: () => import('./views/Logout.vue')
    }
  ]
})
