import axios from "axios";
import NProgress from 'nprogress';

let ApiBaseUrl = document.getElementById("app_base_url").value;
let apiCall = axios.create({
  baseURL: ApiBaseUrl +"/api",
  headers: {
    "Content-type": "application/json"
  }
});
// NProgress.configure({ showSpinner: false });
apiCall.interceptors.request.use(config =>{
  NProgress.start();
  return config
})
apiCall.interceptors.response.use(config =>{
  NProgress.done();
  return config
})
export default apiCall;