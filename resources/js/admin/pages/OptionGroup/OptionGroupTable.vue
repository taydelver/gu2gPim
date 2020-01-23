<template>
  <card title="Option Groups">

    <div class="table-responsive">
      <base-table class="table align-items-center table-flush"
                  :class="type === 'dark' ? 'table-dark': ''"
                  :thead-classes="type === 'dark' ? 'thead-dark': 'thead-light'"
                  tbody-classes="list"
                  :data="tableData">
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
            <base-button type="green" size="sm" icon="fas fa-plus">Values</base-button>
          </td>
        </template>
      </base-table>
    </div>

  </card>
</template>
<script>
  export default {
    name: 'option-group-table',
    props: {
      type: {
        type: String
      },
      tableData: Array,
      refresh: Boolean
    },
    data() {
      return {
        paginate: 3
      }
    },
    created() {
      
    },
    watch: {
      
    },
     methods: {
       
     }
  }
</script>
<style>
</style>