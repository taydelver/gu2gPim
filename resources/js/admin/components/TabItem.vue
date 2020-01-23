<template>
  <div :class="{active: active == toOpen}" class="tab-item">
    <span @click="handleClick">{{label}}</span>
  </div>
</template>

<script>
export default {
  props: {
    label: String,
    toOpen: String,
    active: String
  },
  methods: {
    handleClick() {
      this.$emit('open', this.toOpen)
    }
  },
  computed: {
    renderClass() {

    }
  }
}
</script>

<style lang="scss">
  .tab-item {
    padding: 0.25rem 0.75rem;
    position: relative;
    > span {
      display: block;
      cursor: pointer;
    }
    &.active {
      &:after {
        content: '';
        width: 100%;
        height: 3px;
        background-color: #5e72e4;
        margin-top: 2px;
        display: block;
      }
    }
  }
</style>