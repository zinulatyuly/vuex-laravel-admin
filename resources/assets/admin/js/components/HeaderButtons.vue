<template>
  <div class="box-body">
    <form
      class="form-inline"
      @submit.prevent=""
    >
      <div class="btn-group">
        <router-link
          :to="{ path: $route.path + '/create' }"
          class="btn btn-success btn-sm"
        >
          <i class="fa fa-plus" /> Создать
        </router-link>
        <button
          type="button"
          class="btn btn-default btn-sm"
          @click="$emit('refresh')"
        >
          <i
            :class="{'fa-spin': loading}"
            class="fa fa-refresh"
          /> Обновить
        </button>
      </div>
      <div class="form-group has-feedback pull-right">
        <div class="btn-group">
          <button
            type="button"
            class="btn btn-default btn-sm dropdown-toggle"
          >Поле</button>
          <div class="dropdown-menu clearfix">
            <div class="-col-group-container">
              <ul class="-col-group">
                <label class="-col-group-title">Поля</label>
                <li>
                  <input
                    type="radio"
                    name="Колонки"
                  >
                  <label>#</label>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <input
          type="search"
          class="form-control"
          style="height: 30px"
          placeholder="Поиск"
          @input="filterData"
        >
        <i
          class="form-control-feedback this-30px fa"
          :class="loading || searching ? 'fa-spinner fa-pulse' : 'fa-search'"
          style="line-height: 30px; height: 30px"
        />
      </div>
    </form>
  </div>
</template>

<script>
import debounce from 'debounce-promise';

export default {
  props: {
    columns: {
      Type: Array,
    },
    data: {
      Type: Array,
    },
    loading: {
      Type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      text: null,
      searching: false,
    };
  },
  /* computed: {
      textComputed: {
        get() {
          return this.text;
        },
        set: _.debounce(function(newValue) {
          this.text = newValue;
        }, 500)
      }
    }, */
  methods: {
    filterData: debounce(function (e) {
      this.searching = true;
      const buff = this.data.filter(item => item.name.toLowerCase().includes(e.target.value.toLowerCase()));
      this.$emit('onfilter', buff);
      this.searching = false;
    }, 500),
  },
};
</script>
