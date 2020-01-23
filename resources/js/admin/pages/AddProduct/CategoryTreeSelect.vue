<template>
  <card title="Categories">
    <div class="category-tree">
      <category-tree-item v-for="category in categories" :key="category.id" :item-data="category"></category-tree-item>
    </div>
  </card>
</template>

<script>
import CategoryTreeItem from '../../components/CategoryTreeItem';
export default {
  name: "category-tree-select",
  components: { CategoryTreeItem },
  data() {
    return {
      categories: [],
      selected: []
    };
  },
  created() {
    this.getCategories();
  },
  methods: {
    getSubs(e) {
      console.log(e)
    },
    getCategories() {
      axios.get("/api/category/tree").then(res => {
        console.log(res.data.data);
        this.categories = res.data.data;
      }).catch(err => {
        console.log('errrr')
      });
    },
    hasChildren(children) {
      return children.length > 0;
    }
  },
  computed: {
    newCategories() {
      return this.$store.getters.newProduct.categories
    }
  }
};
</script>

<style>
</style>