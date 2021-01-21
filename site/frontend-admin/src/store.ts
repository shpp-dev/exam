import Vue from "vue";
import Vuex from "vuex";
import createLogger from "vuex/dist/logger";
import api from "@/api";

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    exams: {
      namespaced: true,
      state: {
        list: [],
        selected: null
      },
      mutations: {
        update(state, {data, status}) {
          state.list = data.exams;
          state.selected = status;
        }
      },
      actions: {
        async getExams({commit}, status) {
          const {data} = await api.get(status.key);
          commit("update", {data, status: status.key});
        },

        async checkExam({dispatch}, data) {
          await api.post("check", data.result);
          await dispatch("getExams", {key: data.status});
        }
      }
    },
    client: {
      namespaced: true,
      actions: {
        async saveEverCookie({commit}, data) {
          await api.post("saveEverCookie", data);
        },

        async removeEverCookie({commit}, data) {
          await api.post("removeEverCookie", data);
        },

        async disableCheckingLocation({commit}, data) {
          await api.post("disableCheckingLocation", data);
        }
      }
    }
  },
  plugins: process.env.NODE_ENV !== "production"
    ? [createLogger({
      collapsed: true
    })]
    : []
});
