// axios
import axios from 'axios'

const baseURL = 'http://localhost:8000'
const withCredentials = true

const instance = axios.create({
  baseURL,
  withCredentials
});

export default instance;