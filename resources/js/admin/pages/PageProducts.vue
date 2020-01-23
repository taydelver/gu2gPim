<template>
  <page :alert="alert" title="Products">
    <card has-actions>
      <template #actions>
        <base-button
          type="primary"
          size="sm"
          icon="fas fa-plus"
        >New Product</base-button>
        <table-search></table-search>
      </template>
      <div class="table-responsive">
        <base-table
        v-if="!loading"
          class="table align-items-center table-flush"
          thead-classes="thead-light"
          tbody-classes="list"
          :data="tableData"
        >
          <template slot="columns">
            <th>Name</th>
            <th>SKU</th>
            <th>Price</th>
          </template>

          <template slot-scope="{row}">
            <td>
              <span class="mb-0">
                {{row.name}}
                <div>{{ row.variants.length }} Variants</div>
              </span>
            </td>
           <td>{{row.sku}}</td>
           <td>{{row.price}}</td>
          </template>
        </base-table>
      </div>
    </card>
    <loader class="pt-4 pb-4" :loading="loading"></loader>
  </page>
</template>

<script>

export default {
  data() {
    return {
      search: {
        query: '',
        by: 'name'
      },
      table: {
        data: [],
        page: 1,
        limit: 20
      },
      loading: true,
      alert: {
        show: false,
        text: "New group added successfully!",
        type: "success",
        autoClose: true
      },
    };
  },
  created() {
    this.fetchProducts();
  },
  mounted() {},
  methods: {
    handleAlert(e) {
      this.alert.text = e.text;
      this.alert.type = e.type;
      setTimeout(() => {
        this.alert.show = e.show;
      },400)
    },
    fetchProducts() {
      axios
        .get("/api/products", {
          params: {
            page: this.table.page,
            limit: this.table.limit
          }
        })
        .then(res => {
          console.log(res.data.data);
          this.table.data = res.data.data
          this.loading = false
        });
    },
    handleEdit(index, row) {
        console.log(index, row);
      },
      handleDelete(index, row) {
        console.log(index, row);
      }
  },
  computed: {
    tableData() {
      return this.table.data.filter(data => !this.search.query || data[this.search.by].toLowerCase().includes(this.search.query.toLowerCase()))
    }
  }
};
</script>

<style>
</style>