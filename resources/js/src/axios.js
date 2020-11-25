// axios
import axios from 'axios'

const baseURL = 'http://localhost:8000'

const instance = axios.create({
  baseURL
});
instance.interceptors.request.use(
  config => {
      const token = localStorage.getItem('accessToken');
      if (token) {
          config.headers['Authorization'] = 'Bearer ' + token;
      }
      config.headers['Content-Type'] = 'application/json';
      return config;
  },
  error => {
      Promise.reject(error)
  })

export default instance;