import {useState} from "react"
import PropTypes from "prop-types"
import {
  FormControl,
  FormHelperText,
  IconButton,
  InputAdornment,
  OutlinedInput,
} from "@mui/material"
import {Visibility, VisibilityOff} from "@mui/icons-material"
import {Controller} from "react-hook-form"

FieldPassword.propTypes = {
  name: PropTypes.string.isRequired,
  form: PropTypes.object.isRequired,
  placeholder: PropTypes.string,
}

function FieldPassword(props) {
  const {name, placeholder, form} = props
  const {errors} = form.formState
  const [showPassword, setShowPassword] = useState(false)
  const handleClickShowPassword = () => setShowPassword((show) => !show)
  return (
    <Controller
      name={name}
      control={form.control}
      render={({field}) => (
        <>
          <OutlinedInput
            sx={{mt: 1, mb: 1}}
            fullWidth
            size='small'
            type={showPassword ? "text" : "password"}
            placeholder={placeholder}
            endAdornment={
              <InputAdornment position='end'>
                <IconButton
                  aria-label='toggle password visibility'
                  onClick={handleClickShowPassword}
                  edge='end'>
                  {showPassword ? <VisibilityOff /> : <Visibility />}
                </IconButton>
              </InputAdornment>
            }
            error={!!errors[name]}
            {...field}
          />
          <FormHelperText error={!!errors[name]}>
            {errors[name]?.message}
          </FormHelperText>
        </>
      )}
    />
  )
}

export default FieldPassword
