<template>
  <div class="card form-card">
    <div :class="withActions" class="card-header">
      <h3 v-if="title" class="mb-0">{{ title }}</h3>
        <slot name="actions"></slot>
    </div>
    <div class="card-body">
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: String,
    hasActions: Boolean
  },
  computed: {
    withActions() {
      return this.hasActions ? 'card-header--actions' : ''
    }
  }
}
</script>

<style lang="scss">
  .card-header--actions {
    display: flex;
    align-items: center;
    .action-btn-group {
      margin-left: 20px;
      &--right {
        margin-left: auto;
      }
    }
  }
</style>