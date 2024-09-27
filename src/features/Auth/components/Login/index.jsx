import CloseIcon from '@mui/icons-material/Close'
import { Button } from "@mui/material"
import { unwrapResult } from "@reduxjs/toolkit"
import { useSnackbar } from "notistack"
import PropTypes from "prop-types"
import { useDispatch } from "react-redux"
import { login } from "../../userSlice"
import LoginForm from "../LoginForm"
Login.propTypes = {
  handleClose: PropTypes.func,
}

function Login({ handleClose }) {
  const { enqueueSnackbar, closeSnackbar } = useSnackbar()
  const dispatch = useDispatch()
  const handleSubmit = async (values) => {
    try {
      const data = await dispatch(login(values))
      const resultAction = unwrapResult(data)
      if (resultAction.error === 0) {
        handleClose()
      }
    } catch (error) {
      enqueueSnackbar(error.message, { autoHideDuration: 3000, variant: 'error', action: (snackBarId) => <Button onClick={() => closeSnackbar(snackBarId)}><CloseIcon /></Button> })
    }
  }
  //new
  return (
    <div>
      <LoginForm handleClose={handleClose} handleSubmit={handleSubmit} />
    </div>
  )
}

export default Login
