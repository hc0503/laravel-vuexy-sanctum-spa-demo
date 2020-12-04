// axios
import axios from 'axios'
import router from '@/router'

const baseURL = 'http://localhost:8000'
const withCredentials = true

const instance = axios.create({
  baseURL,
  withCredentials
});

instance.interceptors.response.use(
  response => {
      return response;
  },
  error => {
      if (error.response.status === 401) {
          router.push({ name: 'page-login' })
      }
  })

export default instance;