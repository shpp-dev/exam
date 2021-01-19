import api from "@/api";

const state = {
  task: {},
  tasksAmount: 0,
  deadlineTs: 0,
  finished: false,
  score: 0,
  loading: false,
  remainingTime: 0
};

const actions = {
  async getQuestion({commit}) {
    try {
      const {data} = await api.get("englishQuestion");
      commit("updateTask", data);
    } catch (e) {
      throw e;
    }
  },

  async saveAnswer({state, commit, rootState}, answer) {
    try {
      const {data} = await api.post("englishAnswer", answer);
      commit("updateScore", data.score);
      commit("updateFinished", data.finished.english);
      commit("general/finishExam", data.finished.session, {root: true});
    } catch (e) {
      throw e;
    }
  },

  async finish({commit}) {
    const {data} = await api.post("englishFinish");
    commit("general/finishExam", data.finished.session, {root: true});
  },

  async getRemainingTime({commit}) {
    const {data} = await api.get("englishRemainingTime");
    commit("updateRemainingTime", data);
  }
};

const mutations = {
  updateTask(state, data) {
    state.task = data.task;
    state.tasksAmount = data.tasksAmount;
    state.deadlineTs = data.deadlineTs;
  },

  updateScore(state, score) {
    state.score = score;
  },

  updateFinished(state, finished) {
    state.finished = finished;
  },

  updateRemainingTime(state, data) {
    state.remainingTime = data.remainingTime;
  }
};

export default {
  state,
  actions,
  mutations,
  namespaced: true
};
