function initialState() {
  return {
    item: {
      id: null,
      name: null,
      type: null,
      department: null,
      formSlugs: [],
    },

    departments: {},

    loading: false,
  };
}

const getters = {
  item: state => state.item,
  departments: state => state.departments,
  loading: state => state.loading,
};

const actions = {
  storeData({ commit, state, dispatch }) {
    commit('setLoading', true);
    dispatch('Alert/resetState', null, { root: true });

    return new Promise((resolve, reject) => {
      const params = _.cloneDeep(state.item);

      axios
        .post('/api/internal/admin/forms', params)
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
        .put(`/api/internal/admin/forms/${params.id}`, params)
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
    axios.get(`/api/internal/admin/forms/${id}`).then((response) => {
      commit('setItem', response.data.data);
    });
  },
  fetchDepartments({ commit, state }) {
    axios.get('/api/internal/admin/form-departments').then((response) => {
      commit('departmentsData', response.data.data);
    });
  },
  setName({ commit }, value) {
    commit('setName', value);
  },
  setType({ commit }, value) {
    commit('setType', value);
  },
  setDepartment({ commit }, value) {
    commit('setDepartment', value);
  },
  addFormSlug({ commit }) {
    commit('addFormSlug');
  },
  deleteFormSlug({ commit }, value) {
    commit('deleteFormSlug', value);
  },
  setFormSlug({ commit }, slug) {
    commit('setFormSlug', slug);
  },
  resetState({ commit }) {
    commit('resetState');
  },
};

const mutations = {
  setItem(state, item) {
    state.item = item;
  },
  departmentsData(state, department) {
    state.departments = department;
  },
  setName(state, value) {
    state.item.name = value;
  },
  setType(state, value) {
    state.item.type = value;
  },
  setDepartment(state, value) {
    state.item.department = value;
  },
  addFormSlug(state) {
    state.item.formSlugs.push({
      id: null,
      slug: null,
    });
  },
  deleteFormSlug(state, index) {
    state.item.formSlugs.splice(index, 1);
  },
  setFormSlug(state, { index, slug }) {
    state.item.formSlugs[index].slug = slug;
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
