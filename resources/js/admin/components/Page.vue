<template>
  <div class="page">
    <loader :loading="loading" page-loader></loader>
    <notification
      v-if="alert"
      :show="alert.show"
      :type="alert.type"
      :text="alert.text"
      :auto-close="alert.autoClose"
      animation="slide-down"
      position="fixed-top"
      @close="alert.show = false"
    ></notification>
    <div class="content-header">
      <h2>{{ title }}</h2>
      <slot name="header-right"></slot>
    </div>
    <div class="content">
      <slot></slot>
    </div>
    <slot name="footer"></slot>
  </div>
</template>

<script>
export default {
  props: {
    title: String,
    alert: Object,
    loading: Boolean
  },
};
</script>

<style>
.page {
  padding-bottom: 3rem;
}
</style>