import api from "@/api";

const state = {
  randomText: {},
  loading: false
};

const actions = {
  async getRandomText({commit}) {
    try {
      const {data} = await api.get("randomText");
      commit("updateRandomText", data.randomText);
    } catch (e) {
      throw e;
    }
  },

  async startTypingExam({commit}) {
    try {
      await api.post("typingStart");
    } catch (e) {
      throw e;
    }
  },

  async saveTypingResult({commit}, result) {
    try {
      const {data} = await api.post("typingResult", result);
      commit("general/finishExam", data.finished.session, {root: true});
    } catch (e) {
      throw e;
    }
  }
};

const mutations = {
  updateRandomText(state, randomText) {
    state.randomText = randomText.replace(/<.*?>/g, "").trim();
  }
};

export default {
  state,
  actions,
  mutations,
  namespaced: true
};
