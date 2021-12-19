import { createRouter, createWebHashHistory, RouterView } from 'vue-router'
import Home from './pages/Home.vue'
import MyUrls from './pages/MyUrls.vue'

const routes = [  
  { path: '/', component: Home },
  { path: '/mine', component: MyUrls }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes,
})

export default router;
