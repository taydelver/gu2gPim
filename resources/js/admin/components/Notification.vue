<template>
  <transition :name="animation">
    <div v-if="show" :class="renderClass" class="notify-alert">
      <span class="notify-alert__icon">
        <i class="ni ni-check-bold"></i>
      </span>
      <span class="notify-alert__inner">{{ text }}</span>
      <base-icon
        class="notify-alert__close"
        @click="handleClose"
        v-if="closeable"
        icon="fas fa-times"
      ></base-icon>
    </div>
  </transition>
</template>

<script>
export default {
  props: {
    show: Boolean,
    type: String,
    text: String,
    closeable: Boolean,
    autoClose: Boolean,
    animation: {
      type: String,
      default: 'alert-animation'
    },
    position: {
      type: String,
      default: 'default'
    }
  },
  watch: {
    show() {
      if (this.show) {
        console.log();
        this.handleAutoClose();
      }
    }
  },
  methods: {
    close() {
      this.$emit("close");
    },
    handleClose() {
      this.$emit("close");
    },
    handleAutoClose() {
      if (this.autoClose) {
        setTimeout(() => {
          this.$emit("close");
        }, 2500);
      }
    }
  },
  computed: {
    renderClass() {
      return `${this.position} ${this.type}`
    }
  }
};
</script>

<style lang="scss">
.notify-alert {
	padding: 0.65rem 1rem;
	color: #fff;
	margin-bottom: 1rem;
	&.success {
		background-color: #34bb6c;
	}
	&.fixed-top {
		position: fixed;
		top: 0;
		left: 250px;
		right: 0;
	}
}
.alert-animation-enter-active {
	animation: fade 1s;
}
.alert-animation-leave-active {
	animation: fade 1s reverse;
}

.slide-down-enter-active {
	animation: slide-down 0.7s;
}
.slide-down-leave-active {
	animation: slide-down 0.7s reverse;
}
@keyframes fade {
	0% {
		opacity: 0;
	}
	100% {
		opacity: 1;
	}
}
@keyframes slide-down {
	0% {
		transform: translateY(-100%);
		opacity: 0;
	}
	80% {
		opacity: 1;
	}
	100% {
		transform: translateY(0);
	}
}
</style>