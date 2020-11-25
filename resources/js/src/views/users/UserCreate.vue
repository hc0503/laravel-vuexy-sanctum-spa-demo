<template>
  <div id="users-create">
    <vx-card title="Create User">
      <div class="vx-row">
        <div class="vx-col sm:w-1/2 w-full mb-2">
          <vs-input
            class="w-full"
            label-placeholder="Name"
            v-model="name"
            v-validate="'required'"
            data-vv-validate-on="blur"
            name="name"
          />
          <span class="text-danger text-sm">{{ errors.first('name') }}</span>
        </div>
        <div class="vx-col sm:w-1/2 w-full mb-2">
          <vs-input
            class="w-full"
            label-placeholder="Email"
            v-model="email"
            v-validate="'required|email'"
            data-vv-validate-on="blur"
            name="email"
          />
          <span class="text-danger text-sm">{{ errors.first('email') }}</span>
        </div>
        <div class="vx-col sm:w-1/2 w-full mb-2">
          <vs-input
            class="w-full"
            label-placeholder="Password"
            type="password"
            v-model="password"
            v-validate="'required'"
            data-vv-validate-on="blur"
            name="password"
          />
          <span class="text-danger text-sm">{{ errors.first('password') }}</span>
        </div>
        <div class="vx-col sm:w-1/2 w-full mb-2">
          <vs-input
            class="w-full"
            label-placeholder="Confirm Password"
            type="password"
            v-model="confirmPassword"
            v-validate="'required'"
            data-vv-validate-on="blur"
            name="confirm_password"
          />
          <span class="text-danger text-sm">{{ errors.first('confirm_password') }}</span>
        </div>
        <div class="vx-col sm:w-1/2 w-full mb-2 mt-3">
          <vs-checkbox
            class="inline-flex"
            v-model="status"
            name="status"
          >
            Enable
          </vs-checkbox>
          <span class="text-danger text-sm">{{ errors.first('status') }}</span>
        </div>
        <div class="vx-col sm:w-1/2 w-full mb-2 mt-3">
          <v-select
            label="name"
            :options="roles"
            :dir="$vs.rtl ? 'rtl' : 'ltr'"
            v-model="selectedRole"
            v-validate="'required'"
            data-vv-validate-on="blur"
            name="role"
          />
          <span class="text-danger text-sm">{{ errors.first('role') }}</span>
        </div>
      </div>

      <div class="vx-row mt-5">
        <div class="vx-col w-full text-right">
          <vs-button
            @click="saveUser"  
          >
            Save User
          </vs-button>
        </div>
      </div>
    </vx-card>
  </div>
</template>

<script>
import vSelect from 'vue-select'

export default {
  data () {
    return {
      name: '',
      email: '',
      status: true,
      password: '',
      confirmPassword: '',
      roles: [],
      selectedRole: '',
    }
  },

  components: {
    'v-select': vSelect,
  },

  created () {

  },
  
  mounted () {
    this.getRoles()
  },

  methods: {
    getRoles () {
      this.$http.get('/api/roles')
        .then((response) => {
          this.roles = response.data.data
        })
        .catch((error)   => {
          console.log(error)
        })
    },

    saveUser () {
      this.$vs.loading()
      this.$http.post('/api/users/create', {
        name: this.name,
        password: this.password,
        confirm_password: this.confirmPassword,
        email: this.email,
        status: this.status,
        roles: this.selectedRole,
      })
      .then(() => {
        this.$vs.loading.close()
        this.$vs.notify({
          title: 'Success',
          text: 'The role is stored successfully.',
          iconPack: 'feather',
          icon: 'icon-check',
          position: 'top-right',
          color: 'success'
        })
        this.$router.push({ name: 'users-list' })

      })
      .catch(error => {
        this.$vs.loading.close()
        this.$vs.notify({
          title: 'Failed',
          text: 'The create is failed.',
          iconPack: 'feather',
          icon: 'icon-check',
          position: 'top-right',
          color: 'danger'
        })
      })
    },
  }
}
</script>

<style>

</style>