import api from "@/api";
import {urls} from "@/config";

const state = {
  examStarted: false,
  examFinished: false,
  examsList: {},
  exception: false
};

const actions = {
  async getExamsList({ commit }) {
    const {data} = await api.get("examsList");
    commit("updateExamsList", data.examsList);
  },

  async startExam({commit}) {
    await api.post("startExam");
    commit("startExam", true);
  },

  async getStatus({commit}) {
    const {data} = await api.get("examStatus");
    commit("startExam", data.status === "started");
  },

  async saveZeroStatus({commit}, status) {
    await api.post("saveZeroStatus", status);
    window.location.href = urls.SIGN_IN;
  }
};

const mutations = {
  updateExamsList(state, list: {[key: string]: string}) {
    Object.keys(list).forEach((t) => {
      state.examsList[t] = {
        finished: list[t] === "finished",
        started: list[t] === "inProgress"
      };
    });
  },

  startExam(state, data: boolean) {
    state.examStarted = data;
  },

  finishExam(state, finished: boolean) {
    state.examFinished = finished;
  }
};

export default {
  state,
  actions,
  mutations,
  namespaced: true
};
