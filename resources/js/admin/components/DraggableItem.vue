<template>
  <div class="draggable-item">
    <div class="draggable-item__inner" :class="renderClass">
      <div class="sort-grabber"><i class="fas fa-grip-vertical"></i></div>
      <slot></slot>
      <div v-show="canDelete" @click="remove" class="draggable-remove danger"><i class="fas fa-times"></i></div>
    </div>
    <slot name="full"></slot>
  </div>
</template>

<script>
export default {
  props: {
    canDelete: Boolean,
    iconAlign: {
      type: String,
      default: 'center'
    },
  },
  methods: {
    remove() {
      this.$emit('remove')
    }
  },
  computed: {
    renderClass() {
      return `align-icons--${this.iconAlign}`
    }
  }
}
</script>

<style lang="scss">
.draggable-item {
  margin-bottom: 1rem;
}
  .draggable-item__inner {
    display: flex;
    align-items: center;
    &.align-icons {
      &--top {
        align-items: flex-start;
      }
    }
  }
  .draggable-remove {
    font-size: 14px;
    margin-left: 10px;
    cursor: pointer;
  }
  .align-icons--top {

  }
</style>