<template>
<transition name="slide-panel">
  <div v-show="isOpen" class="slide-panel">
    <div class="slide-panel-container">
      <div @click="close" class="close-panel"><i class="fas fa-times"></i></div>
      <card class="panel-card" :title="title">
        <slot></slot>
      </card>
      <slot name="footer"></slot>
    </div>
    <pop-overlay @close="close"></pop-overlay>
  </div>
</transition>
</template>

<script>
import PopOverlay from './PopOverlay'
export default {
  components: {PopOverlay},
  props: {
    title: String,
    open: Boolean,
  },
  methods: {
    close(e) {
      this.$emit('close')
    },
    check(e) {
      this.close()
    }
  },
  computed: {
    isOpen() {
      return this.open
    }
  }
}
</script>

<style lang="scss">
  .card.panel-card {
    border-radius: 0;
    height: 100%;
    .card-header {
      background: #f8f9fe;
    }
    .card-body {
      margin-bottom: 70px;
      overflow: auto;
    }
  }
  .pop-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.68);
  z-index: 1020;
}

.slide-panel {
  transition: all 0.4s ease;
}

.slide-panel-container {
  max-width: 650px;
  width: 100%;
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  z-index: 1021;
  transition: all 0.4s ease;
  .panel-footer {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 70px;
    background: #fff;
    border-top: 1px solid #e4e7ed;
    align-items: center;
    justify-content: flex-end;
    padding: 0 2rem;
    display: flex;
  }
}

.pop-overlay {
  transition: all 0.2s ease;
}

.slide-panel-enter, .slide-panel-leave-to {
  .slide-panel-container {
    transform: translateX(100%);
    opacity: 0;
  }
  .pop-overlay {
    opacity: 0;
  }
}

.close-panel {
  position: absolute;
  top: 25px;
  right: 26px;
  z-index: 1;
  cursor: pointer;
}
</style>
