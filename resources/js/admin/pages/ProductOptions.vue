<template>
  <page title="Product Options">

    <card has-actions title="Option Groups">
      <div class="action-btn-group" slot="actions">
        <base-button @click="showPanel.new = true" type="primary" size="sm" icon="fas fa-plus">New Group</base-button>
      </div>
        <div class="table-responsive">
          <base-table class="table align-items-center table-flush"
                      
                      thead-classes="thead-light"
                      tbody-classes="list"
                      :data="table.data">
            <template slot="columns">
              <th>Name</th>
              <th class="w-100">Type</th>
              <th>Actions</th>
            </template>

            <template slot-scope="{row}">
              <th scope="row">
                <span class="mb-0 text-sm">{{row.display_name}}</span>
              </th>
              <td>{{ row.type }}</td>
              <td>
                <base-button @click="showPanel.edit = true" type="green" size="sm" icon="fas fa-plus"></base-button>
              </td>
            </template>
          </base-table>
        </div>
    </card>

    <option-group-add @close="closeNewPanel" :open="showPanel.new"></option-group-add>

    


  </page>
</template>

<script>
export default {
  
  data() {
    return {
      showPanel: {
        new: false,
        edit: false
      },
      table: {
        data: [],
        paginate: 20
      },
      currentGroup: {},
      
    }
  },
  created() {
    this.fetchOptionGroups()
  },
  mounted() {
  
  },
  methods: {
    checkRefresh(e) {
      this.refreshTable = true
    },
    closeNewPanel(refresh) {
      this.showPanel.new = false
      this.fetchOptionGroups()
    },
    fetchOptionGroups() {
      axios.get('/api/products/option-groups', {
        params: {
          paginate: this.table.paginate
        }
      })
      .then(res => {
        console.log(res)
        this.table.data = res.data.data
      })
    },
    createGroup() {
      axios.post('/api/products/option-group/create', {
        display_name: this.displayName,
        // type: this.type
      })
      .then(res => {
        this.$emit('refresh', 'created group')
      })
    }
  },
  computed: {
  }
}
</script>

<style>

</style>