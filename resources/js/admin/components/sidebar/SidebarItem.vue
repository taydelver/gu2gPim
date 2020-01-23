<template>
  <li class="nav-item">
    <a @click="toggleDropdown()" v-if="hasDropdown" :class="{open: dropdownActive}" class="nav-link has_dd">
      <i v-if="icon" :class="icon"></i>
      <span class="nav-link-text">{{title}}</span>
    </a>
    <a v-else :href="link" class="nav-link">
      <i v-if="icon" :class="icon"></i>
      <span class="nav-link-text">{{title}}</span>
    </a>
    
    <div v-if="hasDropdown && dropdownActive" class="nav-item__dd">
      <ul class="nav nav-sm flex-column">
        <slot></slot>
      </ul>
    </div>

  </li>
</template>

<script>
export default {
  name: 'sidebar-item',
  props: {
    title: String,
    icon: String,
    link: String,
    hasDropdown: Boolean,
    isDropdown: Boolean,
    baseUrl: String
  },
  data() {
    return {
      dropdownActive: false,
      urlPath: window.location.pathname,
    }
  },
  mounted() {
    setTimeout(this.checkUrl, 400)
  },
  methods: {
    checkUrl() {
      if(this.hasDropdown) {
        if(this.urlPath.includes(this.baseUrl)) {
          this.dropdownActive = true
        } else {
          this.dropdownActive = false
        }
      }
    },
    toggleDropdown() {
      this.dropdownActive = !this.dropdownActive
    },
  },
  computed: {
 
  }
}
</script>

<style lang="scss">
  .nav-item__dd {
    background: #1b1f23;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
  }
  .nav-link.has_dd:after {
    display: inline-block;
    font-style: normal;
    font-variant: normal;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    font-family: "Font Awesome 5 Pro";
    font-weight: 700;
    content: "\F105";
    margin-left: auto;
    color: #ced4da;
    -webkit-transition: all .15s ease;
    transition: all .15s ease;
  }
  .nav-link.has_dd.open:after {
      transform: rotate(90deg);
      color: #565656;
  }
  .nav-link {
    cursor: pointer;
  }
</style>