import debounce from 'debounce-promise';

function initialState() {
  return {
    item: {
      id: null,
      name: null,
      email: null,
      password: null,
      role: null,
    },
    rolesAll: [],
    loading: false,
  };
}

const getters = {
  item: state => state.item,
  loading: state => state.loading,
  rolesAll: state => state.rolesAll,
};

const actions = {
  storeData({ commit, state, dispatch }) {
    commit('setLoading', true);
    dispatch('Alert/resetState', null, { root: true });

    return new Promise((resolve, reject) => {
      const params = _.cloneDeep(state.item);
      if (!_.isEmpty(params.role)) {
        params.role_id = params.role.id;
      }
      if (!_.isEmpty(params.partner)) {
        params.partner_id = params.partner.id;
      }

      axios
        .post('/api/internal/admin/users', params)
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
      if (!_.isEmpty(params.role)) {
        params.role_id = params.role.id;
      }
      if (!_.isEmpty(params.partner)) {
        params.partner_id = params.partner.id;
      }

      axios
        .put(`/api/internal/admin/users/${params.id}`, params)
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
    axios.get(`/api/internal/admin/users/${id}`).then((response) => {
      commit('setItem', response.data.data);
    });

    dispatch('fetchRolesAll');
  },
  fetchRolesAll({ commit }) {
    axios.get('/api/internal/admin/roles').then((response) => {
      commit('setRolesAll', response.data.data);
    });
  },
  setName({ commit }, value) {
    commit('setName', value);
  },
  setEmail({ commit }, value) {
    commit('setEmail', value);
  },
  setPassword({ commit }, value) {
    commit('setPassword', value);
  },
  setRole({ commit }, value) {
    commit('setRole', value);
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
  setEmail(state, value) {
    state.item.email = value;
  },
  setPassword(state, value) {
    state.item.password = value;
  },
  setRole(state, value) {
    state.item.role = value;
  },
  setRolesAll(state, value) {
    state.rolesAll = value;
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
