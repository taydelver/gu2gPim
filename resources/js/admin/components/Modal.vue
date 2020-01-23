<template>
<transition>
  <div v-if="isOpen" class="modal-layout">
    <div class="modal-inner" v-click-outside="close">
      <slot></slot>
    </div>
  </div>
</transition>
</template>

<script>
export default {
  props: {
    open: Boolean,
    slug: String,
  },
  data() {
    return {
      ready: false
    }
  },
  mounted() {
    this.ready = true
  },
  methods: {
    close() {
      if(this.open) {
        this.$emit('close', this.ready)
      }
    }
  },
  computed: {
    isOpen() {
      return this.open
    }
  }
}
</script>

<style>
  .modal-layout {
    position: fixed;
    z-index: 1050;
    top: 0;
    left: 0;
    /* display: none; */
    overflow: hidden;
    width: 100%;
    height: 100%;
    outline: 0;
    background: rgba(0, 0, 0, 0.6);
  }
  .modal-inner {
    max-width: 500px;
    margin: auto;
    display: flex;
    align-items: center;
    height: 100%;
    position: relative;
    top: 50%;
    transform: translateY(-50%);
  }
  .modal-inner .card {
    width: 100%;
  }
</style>