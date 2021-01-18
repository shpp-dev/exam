import api from "@/api";

const state = {
  data: {}
};

const actions = {
  async get({commit}) {
    const {data} = await api.get("profile");
    commit("update", data);
  }
};

const mutations = {
  update(state, data) {
    state.data = data;
  }
};

export default {
  state,
  actions,
  mutations,
  namespaced: true
};
