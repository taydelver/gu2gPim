<template>
  <div class="full-page-container bg-login">
    <!-- Page content -->
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card bg-secondary border-0 mb-0">
            <div class="card-body px-lg-5 py-lg-5">
              <div class="text-center text-muted mb-4">
                <h2>Login</h2>
              </div>
              <form @submit.prevent="login" role="form">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="ni ni-email-83"></i>
                    </span>
                  </div>
                  <input type="email" v-model="email" class="form-control">
                </div>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="ni ni-lock-circle-open"></i>
                    </span>
                  </div>
                  <input type="password" v-model="password" class="form-control">
                </div>
                <div class="text-center">
                  <base-button native-type="submit" type="primary" class="my-4">Sign in</base-button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    data() {
      return {
        email: '',
        password: ''
      };
    },
    methods: {
      login() {
        this.$store.dispatch('login',{
          username: this.email,
          password: this.password
        }).then(res => console.log(res))
      }
    }
  };
</script>
<style lang="scss">
  .full-page-container {
    height: 100vh;
    display: flex;
    align-items: center;
  }
  .bg-login {
    background: #16171b;
  }
</style>"
