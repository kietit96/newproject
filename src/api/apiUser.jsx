import axiosClient from "./axiosClient"

const urlApi = "modules/api.php?do="
const userApi = {
  register(data) {
    return axiosClient.post(`${urlApi}register`, data)
  },
<<<<<<< HEAD
=======
  login(data) {
    return axiosClient.post(`${urlApi}login`, data)
  }
>>>>>>> origin/master
}

export default userApi
