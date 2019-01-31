<template>
  <draggable-tree
    :data="treeData"
    draggable="draggable"
    cross-tree="crossTree"
  >
    <div slot-scope="{data, store}">
      <template v-if="!data.isDragPlaceHolder">

        <span class="tree-node-span">
          <span
            v-if="data.children && data.children.length"
            class="tree-node-span-child"
            :class="data.open ? 'fa fa-arrow-down' : 'fa fa-arrow-right'"
            @click="store.toggleOpen(data)"
          />

          <i
            v-if="data.code"
            class="fa fa-file-image-o"
          />

          <span
            class="tree-node-span-child"
            @click="store.toggleOpen(data)"
          ><b>{{ data.text }}</b></span>

          <small class="tree-node-small-child">{{ data.url }}</small>

        </span>
        <div class="btn-group btn-group-xs pull-right">
          <a
            class="btn btn-success"
            @click="addChild(data)"
          >
            <i class="fa fa-plus" />
          </a>
          <a
            class="btn btn-warning"
            @click="$emit('show-modal', data)"
          >
            <i class="fa fa-edit" />
          </a>
          <a
            class="btn btn-danger"
            @click="deleteData(data)"
          >
            <i class="fa fa-trash" />
          </a>
        </div>
      </template>
    </div>
  </draggable-tree>
</template>

<script>
import { DraggableTree } from 'vue-draggable-nested-tree';

export default {
  components: {
    DraggableTree,
  },
  props: {
    items: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      showModal: false,
      counter: 0,
      treeData: [],
    };
  },
  watch: {
    items: 'convertItemsToData',
  },
  methods: {
    updateData() {
      this.matchParents(this.treeData);
      this.$emit('input', this.treeData);
    },
    addChild(item) {
      if (!item) {
        const arr = this.treeData;
        arr.push({
          id: `new${++this.counter}`,
          text: 'Tree Element',
          url: '#',
          parentId: null,
          sort_order: null,
        });
        this.treeData = arr;
        return;
      }
      this.treeData = this.recourseAdd(this.treeData, item);
    },
    editChild(item) {
      this.treeData = this.recourseEdit(this.treeData, item);
    },
    deleteData(item) {
      this.treeData = this.recourseDelete(this.treeData, item);
    },
    recourseAdd(arr, item) {
      if (arr.indexOf(item) !== -1) {
        if (!arr[arr.indexOf(item)].children) arr[arr.indexOf(item)].children = [];
        arr[arr.indexOf(item)].children.push({
          id: `new${++this.counter}`,
          text: 'Tree Element',
          url: '#',
          parentId: null,
          sort_order: null,
        });
      } else {
        arr.forEach((child) => {
          if (child.children) child.children = this.recourseAdd(child.children, item);
        });
      }
      return arr;
    },
    recourseEdit(arr, obj) {
      const index = arr.findIndex(item => item.id === obj.id);
      if (index !== -1) {
        arr[index].text = obj.text;
        arr[index].url = obj.url;
        arr[index].code = obj.code;
      } else {
        arr.forEach((child) => {
          if (child.children) child.children = this.recourseEdit(child.children, obj);
        });
      }
      return arr;
    },
    recourseDelete(arr, item) {
      if (arr.indexOf(item) !== -1) {
        arr.splice(arr.indexOf(item), 1);
      } else {
        arr.forEach((child) => {
          if (child.children) child.children = this.recourseDelete(child.children, item);
        });
      }
      return arr;
    },
    collapseAll() {
      this.treeData.forEach((item) => {
        item.open = false;
      });
    },
    convertItemsToData() {
      const buff = [];
      const data = this.items;
      data.forEach((item) => {
        if (!item.parentId) {
          buff.push({
            id: item.id,
            text: item.title,
            url: item.url,
            parentId: item.parentId,
            code: item.code,
            children: [],
          });
        }
      });
      this.recourseConvert(buff, data);
      this.treeData = buff;
    },
    recourseConvert(array, data) {
      array.forEach((member) => {
        data.forEach((item) => {
          if (item.parentId === member.id) {
            member.children.push({
              id: item.id,
              text: item.title,
              url: item.url,
              parentId: item.parentId,
              code: item.code,
              children: [],
            });
          }
        });
        if (member.children.length) this.recourseConvert(member.children, data);
      });
      return array;
    },
    matchParents(array) {
      array.forEach((item, index) => {
        item.parentId = null;
        item.sort_order = index;
        if (item.children.length) this.recourseMatching(item);
      });
    },
    recourseMatching(item) {
      item.children.forEach((child, index) => {
        child.parentId = item.id;
        child.sort_order = index;
        if (child.children.length) this.recourseMatching(child);
      });
    },
  },
};
</script>

<style>
.tree-node-small-child {
  color: #999;
}

.he-tree {
  /*border: 1px solid #ccc;*/
  padding: 20px;
}

.tree-node {
  font-size: 14px;
}

.tree-node-inner {
  padding: 10px;
  border-radius: 5px;
  border: 1px solid #ccc;
  cursor: pointer;
  background-color: #f9f9f9;
  min-height: 40px;
}

.tree-node-span-child {
  color: #454545;
}

.tree-node-inner:hover {
  background-color: #fff;
}

.tree-node-span {
  color: #454545;
}

.tree-node-span:hover .tree-node-span-child {
  color: #0088f8;
}

.draggable-placeholder-inner {
  border: 1px dashed #0088f8;
  box-sizing: border-box;
  background: rgba(0, 136, 249, 0.09);
  color: #0088f9;
  text-align: center;
  padding: 0;
  display: flex;
  align-items: center;
}
</style>
