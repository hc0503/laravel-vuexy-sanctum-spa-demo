export default function auth({ next, router }) {
	if (!localStorage.getItem(`userInfo`)) {
		localStorage.removeItem('userInfo')
		return router.push({ name: `page-login` })
	}
	return next();
}