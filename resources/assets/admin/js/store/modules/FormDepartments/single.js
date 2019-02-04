function initialState() {
  return {
    item: {
      id: null,
      department: null,
      departmentTypes: [],
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
        .post('/api/internal/admin/form-departments', params)
        .then((response) => {
          commit('resetState');
          resolve();
        })
        .catch((error) => {
          const message = error.response.data.message || error.message;
          const errors = error.response.data.errors;

          dispatch(
            'Alert/setAlert',
            { message, errors, color: 'danger' },
            { root: true },
          );

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
        .put(`/api/internal/admin/form-departments/${params.id}`, params)
        .then((response) => {
          commit('setItem', response.data.data);
          resolve();
        })
        .catch((error) => {
          const message = error.response.data.message || error.message;
          const errors = error.response.data.errors;

          dispatch(
            'Alert/setAlert',
            { message, errors, color: 'danger' },
            { root: true },
          );

          reject(error);
        })
        .finally(() => {
          commit('setLoading', false);
        });
    });
  },
  fetchData({ commit, dispatch }, id) {
    axios.get(`/api/internal/admin/form-departments/${id}`).then((response) => {
      commit('setItem', response.data.data);
    });
  },
  setDepartment({ commit }, value) {
    commit('setDepartment', value);
  },
  addDepartmentType({ commit }) {
    commit('addDepartmentType');
  },
  deleteDepartmentType({ commit }, value) {
    commit('deleteDepartmentType', value);
  },
  setDepartmentType({ commit }, type) {
    commit('setDepartmentType', type);
  },
  resetState({ commit }) {
    commit('resetState');
  },
};

const mutations = {
  setItem(state, item) {
    state.item = item;
  },
  setDepartment(state, value) {
    state.item.department = value;
  },
  addDepartmentType(state) {
    state.item.departmentTypes.push({
      id: null,
      code: null,
      type: null,
      email: null,
    });
  },
  deleteDepartmentType(state, index) {
    state.item.departmentTypes.splice(index, 1);
  },
  setDepartmentType(state, { index, field, value }) {
    state.item.departmentTypes[index][field] = value;
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
