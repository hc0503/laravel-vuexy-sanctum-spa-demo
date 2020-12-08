<template>
  <div id="roles-list">
    <div class="vx-row">
      <div class="vx-col w-full">
        <vx-card title="Role List">
          <div class="flex flex-wrap justify-end mb-2">
            <vs-button
              icon-pack="feather"
              icon="icon-plus"
              :to="{name: 'roles-create'}"
              v-if="$can('createrole')"
              >
              Add Role
            </vs-button>
          </div>
          <vs-table :data="dispatchedRoles" class="table-dark-inverted">
            <template slot="thead">
              <vs-th>ID.</vs-th>
              <vs-th>Name</vs-th>
              <vs-th>Permissions</vs-th>
              <vs-th>Created At</vs-th>
              <vs-th>Updated At</vs-th>
              <vs-th>Action</vs-th>
            </template>

            <template slot-scope="{data}">
              <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                <vs-td :data="data[indextr].id">
                  <span>#{{data[indextr].id}}</span>
                </vs-td>
                <vs-td :data="data[indextr].id">
                  <span>{{data[indextr].name}}</span>
                </vs-td>
                <vs-td :data="data[indextr].id">
                  <span>
                    <vs-chip v-for="permission in data[indextr].permissions" :key="permission">{{ permission }}</vs-chip>
                  </span>
                </vs-td>
                <vs-td :data="data[indextr].id">
                  <span>{{data[indextr].updated_at}}</span>
                </vs-td>
                <vs-td :data="data[indextr].id">
                  <span>{{data[indextr].created_at}}</span>
                </vs-td>
                <vs-td :data="data[indextr].id">
                  <vs-button
                    :to="{name: 'roles-edit',params: { roleId: data[indextr].id }}"
                    color="primary"
                    type="border"
                    size="small"
                    v-if="$can('editrole')"
                    >
                    Edit
                  </vs-button>
                  <vs-button
                    color="danger"
                    type="border"
                    size="small"
                    @click="openConfirm(data[indextr].id)"
                    v-if="$can('deleterole')"
                    >
                    Delete
                  </vs-button>
                </vs-td>
              </vs-tr>
            </template>
          </vs-table>
        </vx-card>
      </div>
    </div>
  </div>
</template>

<script>
import Button from "../components/vuesax/button/Button.vue"
import axios from '../../axios.js'

export default {
  data () {
    return {
      activeConfirm: false,
      dispatchedRoles: [],
      roleId: 0
    }
  },

  mounted () {
    this.getRoles()
  },

  methods: {
    getRoles () {
      axios.get('/api/roles')
        .then((response) => {
          this.dispatchedRoles = response.data.data
        })
        .catch((error)   => {
          console.log(error)
        })
    },

    openConfirm (roleId) {
      this.roleId = roleId
      this.$vs.dialog({
        type: 'confirm',
        color: 'danger',
        title: `Are you sure?`,
        text: `You can't revert this data.`,
        accept: this.acceptAlert
      })
    },

    acceptAlert () {
      axios.post('/api/roles/delete/' + this.roleId)
        .then((response) => {
          if (response.data.success) {
            this.$vs.notify({
              color: 'success',
              title: 'Deleted role',
              text: 'The selected role was successfully deleted.',
              position: 'top-right',
            })
            this.getRoles()
          }
        })
        .catch((error) => {
          
        })
    },

  }
}
</script>

<style>

</style>