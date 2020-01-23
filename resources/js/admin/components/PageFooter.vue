<template>
  <div class="page__footer">
    <slot></slot>
  </div>
</template>

<script>
export default {
  
}
</script>

<style lang="scss">
.page__footer {
	background: #fff;
	display: flex;
	align-items: center;
	padding-left: 2.5rem;
	padding-right: 2.5rem;
	&.p-fixed {
		position: fixed;
		height: 80px;
		left: 250px;
		right: 0;
		z-index: 1;
		&.p-bottom {
			border-top: 1px solid rgba(0, 0, 0, 0.05);
			bottom: 0;
		}
		&.p-right {
			justify-content: flex-end;
		}
	}
}
</style>