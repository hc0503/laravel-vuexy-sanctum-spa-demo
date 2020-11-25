<template>
  <div id="roles-create">
    <vx-card title="Create Role">
      <div class="vx-row mt-5">
        <div class="vx-col w-1/2">
          <vs-input class="w-1/2 mt-4"
            label="name"
            v-model="name"
            v-validate="'required'"
            data-vv-validate-on="blur"
            name="name" />
          <span class="text-danger text-sm">{{ errors.first('name') }}</span>
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
        <div class="flex flex-wrap justify-end mb-2">
          <vs-button icon-pack="feather" icon="icon-save" @click="saveRole">Save Role</vs-button>
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
    this.$http.get('/api/permissions')
      .then((response) => {
        this.permissions = response.data.data
      })
      .catch((error)   => {
        console.log(error)
      })
  },

  methods: {
    saveRole () {
      this.$vs.loading()
      this.$http.post('/api/roles/create', {
        name: this.name,
        permissions: this.selectedPermissions
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
        this.$router.push({ name: 'roles-list' })

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