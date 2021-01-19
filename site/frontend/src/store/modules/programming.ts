import api from "@/api";
import {ProgrammingTask} from "@/types";

const state = {
  task: null,
  resultCases: [],
  finished: false,
  error: false,
  message: "",
  loading: false,
  remainingTime: 0
};

const actions = {
  async getTask({commit}) {
    const {data} = await api.get("programmingTask");
    commit("updateProgrammingTask", data);
  },

  async saveAnswer({commit}, answer) {
    const {data} = await api.post("programmingAnswer", answer);
    commit("general/finishExam", data.finished.session, {root: true});
    commit("updateProgrammingResult", data);
  },

  async finish({commit}) {
    const {data} = await api.post("programmingFinish");
    commit("general/finishExam", data.finished.session, {root: true});
  },

  async getRemainingTime({commit}) {
    const {data} = await api.get("programmingRemainingTime");
    commit("updateProgrammingRemainingTime", data);
  }
};

const mutations = {
  updateProgrammingTask(state, task: ProgrammingTask) {
    state.task = task;
  },

  updateProgrammingResult(state, data) {
    state.resultCases = data.resultCases;
    state.finished = data.finished.programming;
    state.error = data.error;
    state.message = data.error ? data.message : "";
  },

  updateProgrammingRemainingTime(state, data) {
    state.remainingTime = data.remainingTime;
  }
};

export default {
  state,
  actions,
  mutations,
  namespaced: true
};
