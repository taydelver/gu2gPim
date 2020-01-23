<template>
  <div class="category-tree__item">
    <div class="category-tree__wrap">
      <span v-if="expandable" class="tree-expand">
        <i v-if="!expanded" @click="expand" class="fas fa-plus"></i>
        <i v-if="expanded" @click="expand" class="fas fa-minus"></i>
      </span>
      <div class="custom-control custom-checkbox">
        <input
          :value="itemData.id"
          :id="generateId(itemData.id)"
          type="checkbox"
          class="category-tree__checkbox custom-control-input"
          v-model="item"
        />
        <label class="custom-control-label" :for="generateId(itemData.id)">{{ itemData.name }}</label>
      </div>
    </div>

    <div v-show="itemData.children && expanded" class="category-tree__item-children">
      <category-tree-item
        v-for="category in itemData.children"
        :key="category.id"
        :item-data="category"
      ></category-tree-item>
    </div>
  </div>
</template>

<script>
export default {
  name: "category-tree-item",
  props: {
    itemData: Object,
  },
  data() {
    return {
      expanded: false,
      item: [],
    };
  },
  watch: {
    item() {
      let categories = this.categories
      if(this.item.length) {
        console.log(this.item[0])
        if(categories.indexOf(this.item[0] <= -1)) {
          categories.push(this.item[0])
          this.$store.dispatch('newProductCategories', categories)
        }
      } else {
        let index = categories.indexOf(this.itemData.id)
        const x = categories.filter(item => item !== this.itemData.id)
        this.$store.dispatch('newProductCategories', x)
        console.log(x)
      }
    }
  },
  methods: {
    generateId(id) {
      return `categoryTreeItem${id}`;
    },
    collapse() {
      this.expanded = false;
      this.$emit("collapse");
    },
    getSubs(e) {
      this.cat.push(e[0])
    },
    expand() {
      this.expanded = !this.expanded;
    }
  },
  computed: {
    expandable() {
      return this.itemData.children.length;
    },
    categories() {
      return this.$store.getters.newProduct.categories
    }
  }
};
</script>

<style lang="scss">
.category-tree__item {
  padding: 10px 20px 10px 30px;
  position: relative;
  .custom-control {
    padding-left: 20px;
  }
}
.category-tree__wrap {
  display: flex;
  align-items: center;
}
.tree-expand {
  display: block;
  position: absolute;
  left: 0;
  cursor: pointer;
  font-size: 13px;
}
.category-tree .custom-checkbox .custom-control-input ~ .custom-control-label {
  font-size: 14px;
}
</style>