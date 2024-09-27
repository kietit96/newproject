import { createAsyncThunk, createSlice } from "@reduxjs/toolkit"
import userApi from "../../api/apiUser"
import StorageKey from "../../constants/storages-key"

export const register = createAsyncThunk("users/register", async (payload) => {
  //call api register
  const data = await userApi.register(payload)
  //save local storage
  // localStorage.setItem("access_token", data.token)
  localStorage.setItem(StorageKey.TOKEN, data.response.token)
  localStorage.setItem(StorageKey.USER, JSON.stringify(data.response))
  //return user data
  return data.response
})
export const login = createAsyncThunk("users/login", async (payload) => {
  //call api login
  const data = await userApi.login(payload)
  //save localStorage
  localStorage.setItem(StorageKey.TOKEN, data.response.token)
  localStorage.setItem(StorageKey.USER, JSON.stringify(data.response))
  //return user data
  return data.response
})
const userSlice = createSlice({
  name: "user",
  initialState: {
    current: JSON.parse(localStorage.getItem(StorageKey.USER)) || {},
    settings: {},
  },
  reducers: {},
  extraReducers: (builder) => {
    builder.addCase(register.fulfilled, (state, action) => {
      state.current = action.payload
    })
    builder.addCase(login.fulfilled, (state, action) => {
      state.current = action.payload
    })
  },
})

const { reducer } = userSlice
export default reducer
