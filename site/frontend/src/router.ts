import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

export default new Router({
  mode: "history",
  base: process.env.BASE_URL,
  routes: [
    {
      path: "/",
      name: "home",
        component: () => import(/* webpackChunkName: "programming" */ "./views/Home.vue")
    },
    {
      path: "/programming",
      name: "programming",
      component: () => import(/* webpackChunkName: "programming" */ "./views/Programming.vue")
    },
    {
      path: "/english",
      name: "english",
      component: () => import(/* webpackChunkName: "programming" */ "./views/English.vue")
    },
    {
      path: "/keyboard",
      name: "typeSpeed",
      component: () => import(/* webpackChunkName: "programming" */ "./views/SpeedTyping.vue")
    },
    {
      path: "*",
      name: "pageNotFound",
      component: () => import("./views/PageNotFound.vue")
    }
  ]
});
