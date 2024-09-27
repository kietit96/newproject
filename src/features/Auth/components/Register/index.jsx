import PropTypes from "prop-types"
import { useDispatch } from "react-redux"
import { register } from "../../userSlice"
import RegisterForm from "../RegisterForm"
import { unwrapResult } from "@reduxjs/toolkit"
import { useSnackbar } from "notistack"
import { Button } from "@mui/material"
import CloseIcon from '@mui/icons-material/Close';
Register.propTypes = {
  handleClose: PropTypes.func,
}

function Register({ handleClose }) {
  const { enqueueSnackbar, closeSnackbar } = useSnackbar()
  const dispatch = useDispatch()
  const handleSubmit = async (values) => {
    try {
      const data = await dispatch(register(values))
      const resultAction = unwrapResult(data)
      if (resultAction.error === 0) {
        handleClose()
        enqueueSnackbar("Đăng ký thành công", { autoHideDuration: 3000, variant: "success", action: (snackBarId) => <Button onClick={() => closeSnackbar(snackBarId)}><CloseIcon /></Button> })
      }
    } catch (error) {
      enqueueSnackbar(error.message, { autoHideDuration: 3000, variant: 'error', action: (snackBarId) => <Button onClick={() => closeSnackbar(snackBarId)}><CloseIcon /></Button> })
    }
  }
  return (
    <div>
      <RegisterForm handleClose={handleClose} handleSubmit={handleSubmit} />
    </div>
  )
}

export default Register
