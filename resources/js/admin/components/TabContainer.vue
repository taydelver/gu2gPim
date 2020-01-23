<template>
  <div v-show="show" class="tab-container">
    <slot></slot>
  </div>
</template>

<script>
export default {
  props: {
    show: Boolean 
  }
}
</script>

<style>

</style>