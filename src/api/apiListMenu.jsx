import axiosClient from "./axiosClient"

const urlApi = "modules/api.php?do="
const listMenuApi = {
  getAll() {
    return axiosClient.get(`${urlApi}getListMenu`)
  },
}
export default listMenuApi
