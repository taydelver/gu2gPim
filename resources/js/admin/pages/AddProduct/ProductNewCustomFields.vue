<template>
  <div class="product-new__custom-fields">
    <card :has-actions="hasActions" title="Custom Fields">
      <div class="action-btn-group--right" v-if="attributes.length" slot="actions"><i class="fas fa-cog"></i></div>
      <div v-if="attributes.length < 1" class="text-center pt-3 pb-3">
        <small class="d-block mb-3">No Attributes have been added yet.</small>
        <base-button @click="openPanel" class="d-block m-auto" type="primary" size="lg" icon="fas fa-plus">Add Attributes</base-button>
      </div>
      <div v-if="attributes.length" class="attributes-list">
        <div v-for="(item, key) in attributes" :key="key" class="row">
          <div class="col-md-6">
            <form-group class="mb-1" label="Name">
              <input type="text" v-model="item.name" class="form-control">
            </form-group>
          </div>
          <div class="col-md-6">
            <form-group class="mb-1" label="Value">
              <input type="text" v-model="item.value" class="form-control">
            </form-group>
          </div>
        </div>
      </div>
    </card>
    <add-custom-fields-panel @send-attributes="getAttributes" @close="handleClose" @show-alert="handleAlert" :open="panelOpen"></add-custom-fields-panel>
  </div>
</template>

<script>
import AddCustomFieldsPanel from "./AddCustomFieldsPanel";
export default {
  components: { AddCustomFieldsPanel },
  data() {
    return {
      panelOpen: false,
      attributes: []
    }
  },
  methods: {
    openPanel() {
      this.panelOpen = true
    },
    getAttributes(attributes) {
      this.attributes = attributes
    },
    handleClose() {
      this.panelOpen = false
    },
    handleAlert(alert) {
      this.$emit('alert', alert)
    }
  },
  computed: {
    newAttributes() {
      return this.$store.getters.newAttributes
    },
    hasActions() {
      return this.attributes.length > 0
    }
  }
}
</script>

<style>

</style>