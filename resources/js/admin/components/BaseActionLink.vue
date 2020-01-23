<template>
  <a @click="handleClick" :class="renderClass" class="action-link">
    <i v-if="icon" :class="icon"></i>
    <span class="action-link__text"><slot></slot></span>
  </a>
</template>

<script>
export default {
  props: {
    link: String,
    icon: String,
    size: {
      type: String,
      default: 'md'
    },
    type: {
      type: String,
      default: 'action-link-default',
    },
  },
  methods: {
    handleClick(evt) {
      this.$emit("click", evt);
    }
  },
  computed: {
    renderClass() {
      return `${this.type} ${this.size}`
    }
  }
}
</script>

<style lang="scss">
  .action-link, a.action-link:not([href]):not([tabindex]){
    display: inline-flex;
    align-items: center;
    font-size: 14px;
    cursor: pointer;
    color: #5e72e4;
    &:hover {
      color: #3448b9;
    }
    i {
      font-size: 12px;
      margin-right: 4px;
    }
    &.lg {
      font-size: 16px;
      i {
        font-size: 13.5px;
      }
    }
  }
</style>