<template>
  <div id="users-edit">
    <vx-card title="Edit User">
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
            v-validate="'min:6'"
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
      
      <div class="vx-row mt-5 mb-0">
        <div class="vx-col w-full">
          <div class="flex items-end">
            <feather-icon icon="LockIcon" class="mr-2" />
            <span class="font-medium">Permissions</span>
          </div>
        </div>
      </div>
      <div class="vx-row">
        <div class="vx-col w-full">
          <ul class="demo-alignment">
            <li v-for="permission in permissions" :key="permission.name">
            <vs-checkbox v-model="selectedPermissions" :vs-value="permission.name">{{permission.name}}</vs-checkbox>
            </li>
          </ul>
        </div>
      </div>

      <div class="vx-row mt-5">
        <div class="vx-col w-full text-right">
          <vs-button
            @click="updateUser"
            v-if="$can('edituser')"
            >
            Update User
          </vs-button>
        </div>
      </div>
    </vx-card>
  </div>
</template>

<script>
import vSelect from 'vue-select'
import axios from '../../axios.js'

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
      permissions: [],
    }
  },

  components: {
    'v-select': vSelect,
  },

  created () {

  },
  
  mounted () {
    this.getRoles()
    this.getPermission()
    this.getDetail()
  },

  methods: {
    getDetail() {
      axios.get('/api/users/detail/' + this.$route.params.userId)
        .then((response) => {
          this.name = response.data.data.name
          this.email = response.data.data.email
          this.status = response.data.data.status
          this.selectedRole = response.data.data.role
          this.selectedPermissions = response.data.data.permissions
        })
        .catch((error) => {
          console.log(error)
        })
    },
    getRoles () {
      axios.get('/api/roles')
        .then((response) => {
          this.roles = response.data.data
        })
        .catch((error)   => {
          console.log(error)
        })
    },

    getPermission () {
      axios.get('/api/permissions')
        .then((response) => {
          this.permissions = response.data.data
        })
        .catch((error)   => {
          console.log(error)
        })
    },

    updateUser () {
      this.$vs.loading()
      axios.post('/api/users/update/' + this.$route.params.userId, {
        name: this.name,
        password: this.password,
        confirm_password: this.confirmPassword,
        email: this.email,
        status: this.status,
        roles: this.selectedRole,
        permissions: this.selectedPermissions
      })
      .then(() => {
        this.$vs.loading.close()
        this.$vs.notify({
          title: 'Success',
          text: 'The role is stored successfully.',
          position: 'top-right',
          color: 'success'
        })
        this.$router.push({ name: 'users-list' })

      })
      .catch(error => {
        this.$vs.loading.close()
        for (let item in error.response.data.errors) {
          this.errors.add({
            scope: null,
            field: item,
            rule: 'required',
            msg: error.response.data.errors[item][0]
          })
        }
        this.$vs.notify({
          title: 'Failed',
          text: error.response.data.message,
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