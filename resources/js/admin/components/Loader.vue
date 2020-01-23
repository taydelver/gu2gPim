<template>
  <div v-if="loading" class="loading-container" :class="{fixed: pageLoader}">
      <div v-if="!pageLoader || !overlay" class="loader default"></div>
      <div v-if="overlay" class="loading-overlay"></div>
			<div v-if="pageLoader" class="loading-overlay"></div>
  </div>
</template>

<script>
export default {
  props: {
    loading: Boolean,
		overlay: Boolean,
		pageLoader: Boolean
	},
}
</script>

<style lang="scss">
.loading-container {
	position: relative;
	&.fixed {
		position: fixed;
		top: 0;
		left: 250px;
		right: 0;
		bottom: 0;
		z-index: 1;
	}
}
.loading-overlay {
	height: 100%;
	width: 100%;
	position: absolute;
	background: rgba(255, 255, 255, 0.75);
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	z-index: 10;
}
.loader {
	&.default {
		display: block;
		position: absolute;
		z-index: 11;
		top: 50%;
		left: 50%;
		height: 58px;
		width: 58px;
		margin: -25px 0 0 -25px;
		border: 7px rgba(0, 0, 0, 0.05) solid;
		border-top: 7px #5e72e4 solid;
		border-right: 7px #5e72e4 solid;
		border-bottom: 7px #5e72e4 solid;
		border-radius: 50%;
		animation: loader-default 0.65s infinite linear;
	}
}

@keyframes loader-default {
	from {
		transform: rotate(0deg);
		transform: rotate(0deg);
	}
	to {
		transform: rotate(359deg);
		transform: rotate(359deg);
	}
}
</style>