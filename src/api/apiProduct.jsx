import axiosClient from "./axiosClient"

const urlApi = "modules/api.php?do="
const apiItem = {
  getList() {
    return axiosClient.get(`${urlApi}getProduct`)
  },
}

export default apiItem
