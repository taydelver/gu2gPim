<template>
  <div id="dataSync">
      <div v-if="dataSyncing" :class="alertClass" class="alert" role="alert">
          <span class="animation syncing">
            <i class="fas fa-sync-alt" style="margin-right:10px"></i>
          </span>
          {{ alertText }}
      </div>
     <div class="card">
        <div class="card-header">Products</div>
        <div class="card-body">
            <button @click="runSync" class="btn btn-block btn-primary">Sync Data</button>
        </div>
    </div>
    <datatable :rows="rows">
        <template v-slot="props">
            <td>{{ props.row.id }}</td>
            <td>{{ props.row.project }}</td>
        </template>
    </datatable>
  </div>
</template>

<script>
export default {
    data() {
        return {
            categoryStatus: '',
            dataSyncing: false,
            alertText: 'Syncing store data',
            alertClass: 'alert-info',
            rows: [
                {
                    project: 'Project Title',
                    id: 1

                }
            ]
        }
    },
    created() {
        this.fetchProducts()
    },
    methods: {
        runSync() {
             axios.post('/api/bc/sync/all')
            .then(res => console.log(res))
        },

        fetchProducts() {
            axios.get('/api/bc/fetch/products')
            .then(res => console.log(res))
        }
    }
}
</script>

<style>

</style>