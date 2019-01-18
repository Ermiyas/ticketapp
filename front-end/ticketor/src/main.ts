import Vue from 'vue'
import App from './App.vue'
import VueRouter from 'vue-router'
import HomeView from './Home.vue'
import LoginView from './Login.vue'
import CreateView from './Create.vue' 

Vue.config.productionTip = false;
Vue.use(VueRouter);


const router = new VueRouter({
  mode: "history",
  routes: [
    { path: '/tasks', component: HomeView },
    { path: '/login', component: LoginView },
    { path: '/create', component: CreateView}
  ]
})

const app = new Vue({
  render: h => h(App),
  router: router
}).$mount('#app')
