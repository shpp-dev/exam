import Vue from "vue";
import "./plugins/vuetify";
import "./plugins/luxon";
import "./assets/styles/main.scss";
import store from "./store";
import router from "./router";
import App from "./App.vue";
import i18n from "./i18n";


Vue.config.productionTip = false;


new Vue({
  router,
  store,
  i18n,
  render: (h) => h(App)
}).$mount("#app");
