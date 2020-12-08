const { defineAbility } = require('@casl/ability');

module.exports = defineAbility((can) => {
	$userInfo = JSON.parse(localStorage.getItem('userInfo'));
	$permissions = $userInfo == null ? [] : $userInfo.permissions
	for (const key in $permissions) {
		const element = $permissions[key];
		can(element);
	}
});
