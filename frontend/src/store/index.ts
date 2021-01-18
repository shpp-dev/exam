import Vue from "vue";
import Vuex from "vuex";
import general from "./modules/general";
import user from "./modules/user";
import typing from "./modules/typing";
import english from "./modules/english";
import createLogger from "vuex/dist/logger";
import programming from "./modules/programming";

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    general,
    user,
    typing,
    english,
    programming
  },
  plugins: process.env.NODE_ENV !== "production"
    ? [createLogger({
      collapsed: true
    })]
    : []
});
