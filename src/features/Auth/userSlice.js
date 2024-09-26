import {createAsyncThunk, createSlice} from "@reduxjs/toolkit"
import userApi from "../../api/apiUser"

export const register = createAsyncThunk("users/register", async (payload) => {
  //call api register
  const data = await userApi.register(payload)
  //save local storage
  // localStorage.setItem("access_token", data.token)
  localStorage.setItem("access_user", JSON.stringify(data.response))
  //return user data
  return data.response
})
const userSlice = createSlice({
  name: "user",
  initialState: {
    current: {},
    settings: {},
  },
  reducers: {},
  extraReducers: (builder) => {
    builder.addCase(register.fulfilled, (state, action) => {
      state.current = action.payload
    })
  },
})

const {reducer} = userSlice
export default reducer
