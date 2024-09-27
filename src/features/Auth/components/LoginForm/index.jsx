import { yupResolver } from "@hookform/resolvers/yup"
import { LockOutlined } from "@mui/icons-material"
import CancelRoundedIcon from "@mui/icons-material/CancelRounded"
import {
  Avatar,
  Button,
  createTheme,
  FormLabel,
  LinearProgress,
  Typography,
} from "@mui/material"
import { makeStyles, ThemeProvider } from "@mui/styles"
import PropTypes from "prop-types"
import { useForm } from "react-hook-form"
import * as yup from "yup"
import FieldInput from "../../../../components/form-controller/FieldInput"
import FieldPassword from "../../../../components/form-controller/FieldPassword"

LoginForm.propTypes = {
  handleClose: PropTypes.func,
  handleSubmit: PropTypes.func,
}
AppContent.propTypes = {
  submitForm: PropTypes.func,
  handleClose: PropTypes.func,
  form: PropTypes.object,
}
const useStyle = makeStyles((theme) => ({
  root: {
    paddingTop: theme.spacing(3),
    paddingBottom: theme.spacing(3),
  },
  icon: {
    margin: "0 auto",
  },
  title: {
    textAlign: "center",
  },
  buttonSubmit: {
    "&#button-submit": {
      marginTop: "15px",
    },
  },
  buttonCancel: {
    position: "absolute",
    top: 0,
    right: 0,
    cursor: "pointer",
    "&:hover": {
      color: "#ff2000",
    },
  },
}))
function AppContent(props) {
  const { form, handleClose } = props
  const { isSubmitting } = form.formState
  const handleSubmit = async (values) => {
    const { submitForm } = props
    if (submitForm) {
      await submitForm(values)
    }
  }
  const classes = useStyle()
  return (
    <div className={classes.root}>
      {isSubmitting && <LinearProgress />}
      <Avatar className={classes.icon}>
        <LockOutlined></LockOutlined>
      </Avatar>
      <Typography variant='h4' className={classes.title}>
        Login
      </Typography>
      <form onSubmit={form.handleSubmit(handleSubmit)}>
        <FormLabel htmlFor='email'>Email</FormLabel>
        <FieldInput
          id='email'
          placeholder='youremail@gmail.com'
          name='email'
          type='email'
          form={form}></FieldInput>
        <FormLabel htmlFor='username'>Password</FormLabel>
        <FieldPassword
          placeholder='●●●●'
          name='password'
          type='password'
          form={form}
        />
        <FormLabel htmlFor='username'>Retype password</FormLabel>
        <span className={classes.buttonCancel} onClick={handleClose}>
          <CancelRoundedIcon />
        </span>
        <Button
          disabled={isSubmitting}
          id='button-submit'
          className={classes.buttonSubmit}
          fullWidth
          type='submit'
          variant='contained'>
          Sign in
        </Button>
      </form>
    </div>
  )
}
const theme = createTheme()
function LoginForm(props) {
  const { handleClose, handleSubmit } = props
  const schema = yup
    .object({
      password: yup
        .string()
        .required("không được đề trống")
        .min(6, "Nhập hơn 6 ký tự"),
      email: yup
        .string()
        .required("không được để trống")
        .email("nhập đúng email"),
    })
    .required()
  const form = useForm({
    defaultValues: {
      email: "",
      password: "",
    },
    resolver: yupResolver(schema),
  })
  return (
    <ThemeProvider theme={theme}>
      <AppContent
        handleClose={handleClose}
        form={form}
        submitForm={handleSubmit}
      />
    </ThemeProvider>
  )
}

export default LoginForm
