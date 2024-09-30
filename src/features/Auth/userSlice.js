<<<<<<< HEAD
import {createAsyncThunk, createSlice} from "@reduxjs/toolkit"
import userApi from "../../api/apiUser"
=======
import { createAsyncThunk, createSlice } from "@reduxjs/toolkit"
import userApi from "../../api/apiUser"
import StorageKey from "../../constants/storages-key"
>>>>>>> origin/master

export const register = createAsyncThunk("users/register", async (payload) => {
  //call api register
  const data = await userApi.register(payload)
  //save local storage
  // localStorage.setItem("access_token", data.token)
<<<<<<< HEAD
  localStorage.setItem("access_user", JSON.stringify(data.response))
=======
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
>>>>>>> origin/master
  //return user data
  return data.response
})
const userSlice = createSlice({
  name: "user",
  initialState: {
<<<<<<< HEAD
    current: {},
    settings: {},
  },
  reducers: {},
=======
    current: JSON.parse(localStorage.getItem(StorageKey.USER)) || {},
    settings: {},
  },
  reducers: {
    logout(state) {
      localStorage.removeItem(StorageKey.TOKEN)
      localStorage.removeItem(StorageKey.USER)
      state.current = {}
    }
  },
>>>>>>> origin/master
  extraReducers: (builder) => {
    builder.addCase(register.fulfilled, (state, action) => {
      state.current = action.payload
    })
<<<<<<< HEAD
  },
})

const {reducer} = userSlice
=======
    builder.addCase(login.fulfilled, (state, action) => {
      state.current = action.payload
    })
  },
})

const { actions, reducer } = userSlice
export const { logout } = actions
>>>>>>> origin/master
export default reducer
