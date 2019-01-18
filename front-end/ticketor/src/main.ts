import Vue from 'vue'
import App from './App.vue'
import VueRouter from 'vue-router'
import HomeView from './Home.vue'
import CreateView from './Create.vue'
import LoginView from './Login.vue'

// import CreateView from './Create.vue' 

Vue.config.productionTip = false;
Vue.use(VueRouter);

const routes = [
  // { path: '/tasks', component: HomeView },
  { path: '/login', component: LoginView }
]

const router = new VueRouter({
  routes
})

const app = new Vue({
  render: h => h(App),
  router
}).$mount('#app')
