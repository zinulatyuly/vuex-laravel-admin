function initialState() {
  return {
    all: [],
    relationships: {},
    query: {},
    loading: false,
  };
}

const getters = {
  data: state => state.all,
  total: state => state.all.length,
  loading: state => state.loading,
  relationships: state => state.relationships,
};

const actions = {
  fetchData({ commit, state }) {
    commit('setLoading', true);

    axios
      .get('/api/internal/admin/forms')
      .then((response) => {
        commit('setAll', response.data.data);
      })
      .catch((error) => {
        const message = error.response.data.message || error.message;
        commit('setError', message);
        console.log(message);
      })
      .finally(() => {
        commit('setLoading', false);
      });
  },
  destroyData({ commit, state }, id) {
    axios
      .delete(`/api/internal/admin/forms/${id}`)
      .then((response) => {
        commit('setAll', state.all.filter(item => item.id != id));
      })
      .catch((error) => {
        const message = error.response.data.message || error.message;
        commit('setError', message);
        console.log(message);
      });
  },
  setQuery({ commit }, value) {
    commit('setQuery', purify(value));
  },
  resetState({ commit }) {
    commit('resetState');
  },
};

const mutations = {
  setAll(state, items) {
    state.all = items;
  },
  setLoading(state, loading) {
    state.loading = loading;
  },
  setQuery(state, query) {
    state.query = query;
  },
  resetState(state) {
    state = Object.assign(state, initialState());
  },
};

export default {
  namespaced: true,
  state: initialState,
  getters,
  actions,
  mutations,
};
