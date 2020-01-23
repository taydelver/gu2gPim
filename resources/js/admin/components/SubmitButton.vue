<template>
  <button type="submit" @click="handleClick" class="btn btn-primary btn-submit" :class="classes">
    <span class="btn-inner--icon" v-if="$slots.icon || icon && $slots.default">
      <slot name="icon">
        <i :class="icon"></i>
      </slot>
    </span>
    <i v-if="!$slots.default" :class="icon"></i>
    <span class="btn-inner--text" v-if="$slots.icon || icon && $slots.default">
      <slot>{{text}}</slot>
    </span>
    <slot v-if="!$slots.icon && !icon"></slot>
  </button>
</template>
<script>
export default {
  name: "base-button",
  props: {
    tag: {
      type: String,
      default: "button",
      description: "Button tag (default -> button)"
    },
    size: {
      type: String,
      default: "",
      description: "Button size lg|sm"
    },
    textColor: {
      type: String,
      default: "",
      description: "Button text color (e.g primary, danger etc)"
    },
    icon: {
      type: String,
      default: "",
      description: "Button icon"
    },
    text: {
      type: String,
      default: "",
      description: "Button text in case not provided via default slot"
    },
    outline: {
      type: Boolean,
      default: false,
      description: "Whether button style is outline"
    },
    rounded: {
      type: Boolean,
      default: false,
      description: "Whether button style is rounded"
    },
    iconOnly: {
      type: Boolean,
      default: false,
      description: "Whether button contains only an icon"
    },
    block: {
      type: Boolean,
      default: false,
      description: "Whether button is of block type"
    }
  },
  computed: {
    classes() {
      let btnClasses = [
        { "btn-block": this.block },
        { "rounded-circle": this.rounded },
        { "btn-icon-only": this.iconOnly },
        { [`text-${this.textColor}`]: this.textColor },
        { "btn-icon": this.icon || this.$slots.icon }
      ];
      if (this.size) {
        btnClasses.push(`btn-${this.size}`);
      }
      return btnClasses;
    }
  },
  methods: {
    handleClick(evt) {
      this.$emit("click", evt);
    }
  }
};
</script>
<style>
.btn-md {
  font-size: 0.875rem;
  padding: 0.5rem 1rem;
}
</style>
