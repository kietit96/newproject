import PropTypes from "prop-types"
import { useDispatch } from "react-redux"
import { register } from "../../userSlice"
import RegisterForm from "../RegisterForm"
import { unwrapResult } from "@reduxjs/toolkit"

Register.propTypes = {
  handleClose: PropTypes.func,
}

function Register({ handleClose }) {
  const dispatch = useDispatch()
  const handleSubmit = async (values) => {
    try {
      const data = await dispatch(register(values))
      const resultAction = unwrapResult(data)
      console.log("uer:", resultAction)
    } catch (error) {
      console.error(error)
    }
  }
  return (
    <div>
      <RegisterForm handleClose={handleClose} handleSubmit={handleSubmit} />
    </div>
  )
}

export default Register
