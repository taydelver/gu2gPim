<template>
    <div :class="customClass" class="form-group">
      <label class="form-control-label">{{ label }}
        <span v-if="hint" class="input-hint">{{ hint }}</span>
      </label>
      <div class="has-label">
        <slot></slot>
      </div>
      <div v-if="err" class="form-feedback form-feedback--error">
        {{ error }}
      </div>
    </div>
</template>

<script>
export default {
  props: {
    label: String,
    error: String,
    hint: String
  },
  computed: {
    err() {
      return this.error !== '' || this.error
    },
    customClass() {
      if(this.err) {
        return 'has-error'
      }
    }
  }
}
</script>

<style lang="scss">
  .form-feedback {
    font-size: 13px;
    &--error {
      color: #fb6340
    }
  }
</style>