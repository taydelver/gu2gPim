<template>
  <span @click="handleClick" :class="[customClass, type]" class="icon-btn">
    <i :class="icon"></i>
  </span>
</template>

<script>
export default {
  props: {
    icon: String,
    size: String,
    type: String
  },
  methods: {
    handleClick(evt) {
      this.$emit('click', evt)
    }
  },
  computed: {
    customClass() {
      if(this.size) {
        return `icon-btn--${this.size}`
      } else {
        return ''
      }
    }
  }
}
</script>

<style lang="scss">
  .icon-btn {
    display: inline-block;
    cursor: pointer;
    &:hover {
      opacity: 0.5;
    }
    &--sm {
      font-size: 14px;
    }

  }
</style>