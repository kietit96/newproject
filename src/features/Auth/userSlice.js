import {createSlice} from "@reduxjs/toolkit"

const userSlice = createSlice({
  name: "user",
  initialState: {
    user: {},
    setting: {},
  },
  reducers: {},
})

const {reducer} = userSlice
export default reducer
