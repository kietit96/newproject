import PropTypes from "prop-types"
import {useDispatch} from "react-redux"
import {register} from "../../userSlice"
import RegisterForm from "../RegisterForm"

Register.propTypes = {
  handleClose: PropTypes.func,
}

function Register({handleClose}) {
  const dispatch = useDispatch()
  const handleSubmit = async (values) => {
    const data = await dispatch(register(values)).unwrap()
    console.log(data)
  }
  return (
    <div>
      <RegisterForm handleClose={handleClose} handleSubmit={handleSubmit} />
    </div>
  )
}

export default Register
