<template>
  <div class="product-new__fitments">
    <card title="Fitments">
      <div v-if="newFitments.length < 1" class="text-center pt-3 pb-3">
        <small class="d-block mb-3">No Fitments have been added yet.</small>
        <base-button @click="openPanel" class="d-block m-auto" type="primary" size="lg" icon="fas fa-plus">Add Fitments</base-button>
      </div>
      <div class="applied-fitments-list" v-if="newFitments">
        <div v-for="(group, index) in fitmentsRender" :key="index" class="fitment-group">
          <h5 class="mb-0">{{ group.name }}</h5>
          <div class="fitment-group__values">
            <span style="font-size: 12px" class="small-tag" v-for="(item, i) in group.values" :key="i">{{ item }}</span>
          </div>
        </div>
      </div>
    </card>
    <add-fitments-panel @close="handleClose" @show-alert="handleAlert" :open="panelOpen"></add-fitments-panel>
  </div>
</template>

<script>
import AddFitmentsPanel from "./AddFitmentsPanel";
export default {
  components: { AddFitmentsPanel },
  data() {
    return {
      panelOpen: false
    }
  },
  methods: {
    openPanel() {
      this.panelOpen = true
    },
    handleClose() {
      this.panelOpen = false
    },
    handleAlert(alert) {
      this.$emit('alert', alert)
    }
  },
  computed: {
    newFitments() {
      return this.$store.getters.newFitments
    },
    fitmentsRender() {
      let rendered = []
      const groups = this.newFitments.map(item => item.name)
      .filter((value, index, self) => self.indexOf(value) === index)
      groups.forEach(group => {
        const item = {
          name: group,
          values: this.newFitments.filter(fitment => fitment.name == group).map(v => v.value)
        }
        rendered.push(item)
      });
      return rendered
    }
  }
}
</script>

<style>
  .fitment-group {
    margin-bottom: 0.75rem;
  }
</style>