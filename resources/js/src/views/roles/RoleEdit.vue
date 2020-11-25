<template>
  <div id="roles-create">
    <vx-card title="Create Role">
      <div class="vx-col w-1/2">
        <vs-input class="w-1/2 mt-4"
          label="name"
          v-model="name"
          v-validate="'required'"
          data-vv-validate-on="blur"
          name="name" />
        <span class="text-danger text-sm">{{ errors.first('name') }}</span>
      </div>
      <div class="vx-row mt-5">
        <div class="vx-col w-full">
          <div class="flex items-end px-3">
            <feather-icon svgClasses="w-6 h-6" icon="LockIcon" class="mr-2" />
            <span class="font-medium text-lg leading-none">Permissions</span>
          </div>
          <vs-divider />
        </div>
      </div>
        <div class="row">
          <div v-for="permission in permissions" :key="permission.name" class="col w-1/4">
            <input type="checkbox" :id="permission.name" :value="permission.name" v-model="selectedPermissions" @click="consoleVal">
            <label :for="permission.name">{{permission.name}}</label>
          </div>
        </div>
        <div class="flex flex-wrap justify-end mb-2">
          <vs-button icon-pack="feather" icon="icon-save" @click="updateRole">Update Role</vs-button>
        </div>
    </vx-card>
  </div>
</template>

<script>

export default {
  data () {
    return {
      selectedPermissions: [],
      permissions: [],
      name: ''
    }
  },

  created () {

  },

  mounted () {
    this.getPermission()
    this.getDetail()
  },

  methods: {
    getDetail() {
      this.$http.get('/api/roles/detail/' + this.$route.params.roleId)
        .then((response) => {
          this.selectedPermissions = response.data.data.permissions
          this.name = response.data.data.name
        })
        .catch((error) => {
          console.log(error)
        })
    },

    getPermission () {
      this.$http.get('/api/permissions')
        .then((response) => {
          this.permissions = response.data.data
        })
        .catch((error)   => {
          console.log(error)
        })
    },

    updateRole () {
      this.$vs.loading()
      this.$http.post('/api/roles/update/' + this.$route.params.roleId, {
        name: this.name,
        permissions: this.selectedPermissions
      })
      .then(() => {
        this.$vs.loading.close()
        this.$vs.notify({
          title: 'Success',
          text: 'The role is updated successfully.',
          iconPack: 'feather',
          icon: 'icon-check',
          position: 'top-right',
          color: 'success'
        })
        this.$router.push({ name: 'roles-list' })
      })
      .catch(error => {
        this.$vs.loading.close()
        this.$vs.notify({
          title: 'Failed',
          text: 'The update is failed.',
          iconPack: 'feather',
          icon: 'icon-check',
          position: 'top-right',
          color: 'danger'
        })
      })
    },

    consoleVal () {
      console.log(this.selectedPermissions)
    }
  }
}
</script>

<style>

</style>