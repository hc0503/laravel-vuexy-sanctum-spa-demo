<template>
  <vs-button class="mb-4 ml-2" @click="loginAuth0" color="#eb5424">Auth0</vs-button>
</template>

<script>
export default {
  methods: {
    checkLogin () {
      // If user is already logged in notify
      if (this.$store.state.auth.isUserLoggedIn()) {

        // Close animation if passed as payload
        // this.$vs.loading.close()

        this.$vs.notify({
          title: 'Login Attempt',
          text: 'You are already logged in!',
          iconPack: 'feather',
          icon: 'icon-alert-circle',
          color: 'warning'
        })

        return false
      }
      return true
    },

    loginAuth0 () {
      if (!this.checkLogin()) return
      this.$auth.login({ target: this.$route.query.to })
    },
    registerUser () {
      if (!this.checkLogin()) return
      this.$router.push('/pages/register').catch(() => {})
    }
  }
}

</script>
