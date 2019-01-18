function initialState() {
  return {
    item: {
      id: null,
      displayName: null,
      key: null,
      value: null,
      group: null,
      type: null,
      order: null,
      details: null,
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
        .post('/api/internal/admin/settings', params)
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
        .put(`/api/internal/admin/settings/${params.id}`, params)
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
    axios.get(`/api/internal/admin/settings/${id}`).then((response) => {
      commit('setItem', response.data.data);
    });
  },
  setKey({ commit }, value) {
    commit('setKey', value);
  },
  setDisplayName({ commit }, value) {
    commit('setDisplayName', value);
  },
  setValue({ commit }, value) {
    commit('setValue', value);
  },
  setDetails({ commit }, value) {
    commit('setDetails', value);
  },
  setType({ commit }, value) {
    commit('setType', value);
  },
  setOrder({ commit }, value) {
    commit('setOrder', value);
  },
  setGroup({ commit }, value) {
    commit('setGroup', value);
  },
  resetState({ commit }) {
    commit('resetState');
  },
};

const mutations = {
  setItem(state, item) {
    state.item = item;
  },
  setKey(state, value) {
    state.item.key = value;
  },
  setDisplayName(state, value) {
    state.item.displayName = value;
  },
  setValue(state, value) {
    state.item.value = value;
  },
  setDetails(state, value) {
    state.item.details = value;
  },
  setType(state, value) {
    state.item.type = value;
  },
  setOrder(state, value) {
    state.item.order = value;
  },
  setGroup(state, value) {
    state.item.group = value;
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
