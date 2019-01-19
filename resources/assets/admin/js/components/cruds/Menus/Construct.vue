<template>
  <section
    class="content-wrapper"
    style="min-height: 960px;"
  >
    <section class="content-header">
      <h1>Меню</h1>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <form @submit.prevent="submitForm">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Конструктор</h3>
              </div>

              <div class="box-body">
                <back-buttton />
                <div class="pull-right">
                  <button
                    type="button"
                    class="btn btn-success btn-sm"
                    @click="addTreeElement"
                  >
                    <i class="fa fa-lg fa-plus-square" />
                    Добавить элемент
                  </button>
                  <button
                    type="button"
                    class="btn btn-default btn-sm"
                    @click="collapseTree"
                  >
                    <i class="fa fa-lg fa-arrow-circle-right" />
                    Свернуть все
                  </button>
                </div>
              </div>
              <div class="box-body">
                <div class="col-xs-12">
                  <tree
                    ref="tree"
                    :items="item.items"
                    @input="updateItems($event)"
                    @show-modal="editModal($event)"
                  />
                  <modal
                    v-if="showModal"
                    :item="editData"
                    @close="editTreeElement($event)"
                  />
                </div>
              </div>

              <div class="box-footer">
                <vue-button-spinner
                  :is-loading="loading"
                  :disabled="loading"
                  class="btn btn-primary btn-sm"
                >
                  Сохранить
                </vue-button-spinner>
              </div>

            </div>
          </form>
        </div>
      </div>
    </section>
  </section>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import Modal from './partials/Modal';
import Tree from './partials/Tree';

export default {
  components: {
    Tree,
    Modal,
  },
  data() {
    return {
      editData: null,
      showModal: false,
      data: [],
    };
  },
  created() {
    this.fetchData(this.$route.params.id);
  },
  destroyed() {
    this.resetState();
  },
  computed: {
    ...mapGetters('MenusSingle', ['item', 'loading']),
  },
  watch: {
    '$route.params.id': function () {
      this.resetState();
      this.fetchData(this.$route.params.id);
    },
  },
  methods: {
    ...mapActions('MenusSingle', ['fetchData', 'updateData', 'resetState', 'setItems']),
    updateItems(e) {
      const buff = [];
      this.recourseRevert(buff, e);
      this.setItems(buff);
    },
    collapseTree() {
      this.$refs.tree.collapseAll();
    },
    addTreeElement() {
      this.$refs.tree.addChild();
    },
    editModal(e) {
      this.editData = {
        id: e.id,
        text: e.text,
        url: e.url,
        code: e.code,
      };
      this.showModal = true;
    },
    editTreeElement(e) {
      if (e) this.$refs.tree.editChild(e);
      this.showModal = false;
    },
    recourseRevert(buff, data) {
      data.forEach((item) => {
        item.has_children = false;
        if (item.children.length) {
          item.has_children = true;
          this.recourseRevert(buff, item.children);
        }
        buff.push({
          id: item.id,
          title: item.text,
          url: item.url,
          has_children: item.has_children,
          parentId: item.parentId,
          order: item.order,
          code: item.code,
        });
      });
    },
    submitForm() {
      this.$refs.tree.updateData();
      this.updateData()
        .then(() => {
          this.$router.push({ name: 'menus.index' });
          this.$eventHub.$emit('create-success');
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
};
</script>
