<template>
  <div id="users-list">
    <div class="vx-row">
      <div class="vx-col w-full">
        <vx-card title="Role List">
          <div class="flex flex-wrap justify-end mb-2">
            <vs-button icon-pack="feather" icon="icon-plus" :to="{name: 'users-create'}">Add User</vs-button>
          </div>
          <vs-table :data="dispatchedUsers" class="table-dark-inverted">
            <template slot="thead">
              <vs-th>ID.</vs-th>
              <vs-th>Name</vs-th>
              <vs-th>Email</vs-th>
              <vs-th>Roles</vs-th>
              <vs-th>Status</vs-th>
              <vs-th>Created At</vs-th>
              <vs-th>Updated At</vs-th>
              <vs-th>Action</vs-th>
            </template>

            <template slot-scope="{data}">
              <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                <vs-td :data="data[indextr].id">
                  <span>#{{ data[indextr].id }}</span>
                </vs-td>
                <vs-td :data="data[indextr].id">
                  <span>{{ data[indextr].name }}</span>
                </vs-td>
                <vs-td :data="data[indextr].id">
                  <span>{{ data[indextr].email }}</span>
                </vs-td>
                <vs-td :data="data[indextr].id">
                  <span v-if="data[indextr].role">
                    <vs-chip>{{ data[indextr].role }}</vs-chip>
                  </span>
                </vs-td>
                <vs-td :data="data[indextr].id">
                  <span>
                    <vs-switch color="success" v-model="data[indextr].status">
                      <span slot="on">Enable</span>
                      <span slot="off">Disable</span>
                    </vs-switch>
                  </span>
                </vs-td>
                <vs-td :data="data[indextr].id">
                  <span>{{ data[indextr].updated_at }}</span>
                </vs-td>
                <vs-td :data="data[indextr].id">
                  <span>{{ data[indextr].created_at }}</span>
                </vs-td>
                <vs-td :data="data[indextr].id">
                  <vs-button
                    :to="{name: 'users-edit',params: { userId: data[indextr].id }}"
                    color="primary"
                    type="border"
                    size="small"
                    >
                  Edit
                  </vs-button>
                  <vs-button
                    color="danger"
                    type="border"
                    size="small"
                    @click="openConfirm(data[indextr].id)"
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

export default {
  data () {
    return {
      activeConfirm: false,
      dispatchedUsers: [],
      userId: 0,
    }
  },

  mounted () {
    this.getUsers()
  },

  methods: {
    getUsers () {
      this.$http.get('/api/users')
        .then((response) => {
          this.dispatchedUsers = response.data.data
        })
        .catch((error)   => {
          console.log(error)
        })
    },

    openConfirm (userId) {
      this.userId = userId
      this.$vs.dialog({
        type: 'confirm',
        color: 'danger',
        title: `Are you sure?`,
        text: `You can't revert this data.`,
        accept: this.acceptAlert
      })
    },

    acceptAlert () {
      this.$http.post('/api/users/delete/' + this.userId)
        .then((response) => {
          if (response.data.success) {
            this.$vs.notify({
              color: 'success',
              title: 'Deleted role',
              text: 'The selected role was successfully deleted.'
            })
            this.getUsers()
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