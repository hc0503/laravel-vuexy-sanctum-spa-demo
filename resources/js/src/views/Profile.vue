<template>
	<div id="profile">
		<vx-card title="Profile">
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
        			data-vv-validate-on="blur"
        			v-validate="'required|min:6'"
					class="w-full"
					label-placeholder="Password"
					type="password"
					v-model="password"
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
			</div>

			<div class="vx-row mt-5">
			<div class="vx-col w-full text-right">
				<vs-button
					@click="updateProfile"  
				>
					Update Profile
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
			password: '',
			confirmPassword: '',
		}
	},

	mounted () {
		this.getProfile()
	},

	methods: {
		getProfile() {
			this.$http.get('/api/profile')
			.then((response) => {
				console.log(this.name)
				this.name = response.data.data.name
				this.email = response.data.data.email
			})
			.catch((error) => {
				console.log(error)
			})
		},

		updateProfile () {
			this.$vs.loading()
			this.$http.post('/api/profile/update', {
				name: this.name,
				password: this.password,
				confirm_password: this.confirmPassword,
				email: this.email,
			})
			.then(() => {
			this.$vs.loading.close()
				this.$vs.notify({
					title: 'Success',
					text: 'The role is stored successfully.',
					position: 'top-right',
					color: 'success'
				})
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