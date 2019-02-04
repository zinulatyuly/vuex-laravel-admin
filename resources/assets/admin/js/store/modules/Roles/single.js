function initialState() {
  return {
    item: {
      id: null,
      name: null,
      displayName: null,
    },

    loading: false,
  };
}

const getters = {
  item: state => state.item,
  loading: state => state.loading,
};

const actions = {
  storeData({ commit, state, dispatch }) {
    commit('setLoading', true);
    dispatch('Alert/resetState', null, { root: true });

    return new Promise((resolve, reject) => {
      const params = _.cloneDeep(state.item);

      axios
        .post('/api/internal/admin/roles', params)
        .then((response) => {
          commit('resetState');
          resolve();
        })
        .catch((error) => {
          const message = error.response.data.message || error.message;
          const errors = error.response.data.errors;

          dispatch('Alert/setAlert', { message, errors, color: 'danger' }, { root: true });

          reject(error);
        })
        .finally(() => {
          commit('setLoading', false);
        });
    });
  },
  updateData({ commit, state, dispatch }) {
    commit('setLoading', true);
    dispatch('Alert/resetState', null, { root: true });

    return new Promise((resolve, reject) => {
      const params = _.cloneDeep(state.item);

      axios
        .put(`/api/internal/admin/roles/${params.id}`, params)
        .then((response) => {
          commit('setItem', response.data.data);
          resolve();
        })
        .catch((error) => {
          const message = error.response.data.message || error.message;
          const errors = error.response.data.errors;

          dispatch('Alert/setAlert', { message, errors, color: 'danger' }, { root: true });

          reject(error);
        })
        .finally(() => {
          commit('setLoading', false);
        });
    });
  },
  fetchData({ commit, dispatch }, id) {
    axios.get(`/api/internal/admin/roles/${id}`).then((response) => {
      commit('setItem', response.data.data);
    });
  },
  setName({ commit }, value) {
    commit('setName', value);
  },
  setDisplayName({ commit }, value) {
    commit('setDisplayName', value);
  },
  resetState({ commit }) {
    commit('resetState');
  },
};

const mutations = {
  setItem(state, item) {
    state.item = item;
  },
  setName(state, value) {
    state.item.name = value;
  },
  setDisplayName(state, value) {
    state.item.displayName = value;
  },

  setLoading(state, loading) {
    state.loading = loading;
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
