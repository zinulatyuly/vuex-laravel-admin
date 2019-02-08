function initialState() {
  return {
    item: {
      id: null,
      name: null,
      typeId: null,
      departmentId: null,
      slugs: [],
  
      department: {},
      type: {}
    },

    departments: [
      { departmentTypes: [] }
    ],
    types: [],

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
    axios.get(`/api/internal/admin/forms/${id}`).then(({data}) => {
      commit('setItem', data.data);
      //commit('setDepartment', { ... data.data.department, ... { departmentTypes: [data.data.departmentType]}})
    });
  },
  fetchDepartments({ commit, state }) {
    axios.get('/api/internal/admin/form-departments').then((response) => {
      commit('setDepartments', response.data.data);
    });
  },
  setName({ commit }, value) {
    commit('setName', value);
  },
  setTypeId({ commit }, value) {
    commit('setTypeId', value);
  },
  setDepartmentId({ commit }, value) {
    commit('setDepartmentId', value);
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
  setDepartments(state, departments) {
    state.departments = departments;
  },
  setName(state, value) {
    state.item.name = value;
  },
  setTypeId(state, value) {
    state.item.typeId = value;
  },
  setDepartmentId(state, value) {
    state.item.departmentId = value;
  },
  addFormSlug(state) {
    state.item.slugs.push({
      id: null,
      slug: null,
    });
  },
  deleteFormSlug(state, index) {
    state.item.slugs.splice(index, 1);
  },
  setFormSlug(state, { index, slug }) {
    state.item.slugs[index].slug = slug;
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
