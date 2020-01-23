<template>
  <div @click="close($event)" class="pop-overlay"></div>
</template>

<script>
export default {
  props: {
    open: Boolean
  },
  methods: {
    close(e) {
      this.$emit('close', 'closed me')
    }
  }
}
</script>