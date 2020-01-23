<template>
  <div class="card form-card">
    <div class="card-header">
      <h3 class="mb-0">{{ title }}</h3>
    </div>
    <div class="card-body">
      <slot name="form"></slot>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: String
  }
}
</script>

<style>

</style>