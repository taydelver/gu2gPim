<template>
  <div class="tab-list">
    <tab-item :active="active" :label="tab.label" :to-open="tab.toOpen" @open="openTab(tab.toOpen)" v-for="(tab, key) in tabItems" :key="key"></tab-item>
  </div>
</template>

<script>
export default {
  props: {
    tabItems: Array,
    active: String,
  },
  data() {
    return {
      currentTab: ''
    }
  },
  methods: {
    openTab(tab) {
      this.currentTab = tab
      this.$emit('current-tab', this.currentTab)
    }
  }
}
</script>

<style>
  .tab-list {
    display: flex;
    margin-bottom: 0.75rem;
  }
</style>