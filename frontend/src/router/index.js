import { createRouter, createWebHistory } from 'vue-router'
import LoginView from "@/views/LoginView.vue";
import QuizeView from "@/views/QuizeView.vue";
import axios from "axios";
import AdminView from "@/views/adminPanel/AdminView.vue";
import ResultView from "@/views/ResultView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: LoginView
    },
    {
      path: '/quize',
      name: 'quize',
      component: QuizeView
    },
    {
      path: '/result',
      name: 'result',
      component: ResultView
    },
    {
      path: '/admin',
      name: 'admin',
      component: AdminView,
      meta: {
        requiresAdmin: true,
      }
    }
  ]
})


router.beforeEach((to, from) => {
  if(to.name === 'login') {
    return true;
  }
  if(!localStorage.getItem('token')) {
    return {
      name: 'login'
    }
  }

  checkTokenAuthenticity()
})

const checkTokenAuthenticity = () => {
  axios.get('/api/user', {
    headers: {
      Authorization: `Bearer ${localStorage.getItem('token')}`
    }
  })
      .then((response) => {})
      .catch((error) => {
        localStorage.removeItem('token')
        router.push({
          name: 'login'
        })
      })
}

export default router
