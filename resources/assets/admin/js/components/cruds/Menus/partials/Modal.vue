<template>
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <form @submit.prevent="onSubmit">
            <div class="modal-header">
              <h3 slot="header">Изменить</h3>
            </div>
            <div class="modal-body">

              <div class="form-group">
                <label>Название</label>
                <input
                  v-model="item.text"
                  type="text"
                  class="form-control"
                >
              </div>
              <div class="form-group">
                <label>URL</label>
                <input
                  v-model="item.url"
                  type="text"
                  class="form-control"
                >
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-light"
                @click="$emit('close')"
              >
                Назад
              </button>
              <button
                type="submit"
                class="btn btn-primary"
                @click="$emit('close', item)"
              >
                Сохранить
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  props: {
    item: {},
  },
  methods: {
    onSubmit() {},
  },
};
</script>

<style>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 500px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
}

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>
