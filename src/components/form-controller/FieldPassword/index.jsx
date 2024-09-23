import React from 'react';
import PropTypes from 'prop-types';
import { FormControl, IconButton, InputAdornment, InputLabel, OutlinedInput } from '@mui/material';
import { Visibility, VisibilityOff } from '@mui/icons-material';
import { Controller } from 'react-hook-form';

FieldPassword.propTypes = {
    name: PropTypes.string.isRequired,
    form: PropTypes.object.isRequired,
    placeholder: PropTypes.string,
    type: PropTypes.string,
};

function FieldPassword(props) {
    const { name, placeholder, type, form } = props
    const { errors } = form.formState
    const [showPassword, setShowPassword] = React.useState(false);
    const handleClickShowPassword = () => setShowPassword((show) => !show);
    const handleMouseDownPassword = (event) => {
        event.preventDefault();
    }

    const handleMouseUpPassword = (event) => {
        event.preventDefault();
    }
    return (
        <Controller
            name={name}
            control={form.control}
            render={() =>
                <OutlinedInput
                    error={!!errors[name]}
                    helperText={errors[name]?.message}
                    fullWidth
                    size='small'
                    id="outlined-adornment-password"
                    type={showPassword ? 'text' : 'password'}
                    placeholder={placeholder}
                    endAdornment={
                        <InputAdornment position="end">
                            <IconButton
                                aria-label="toggle password visibility"
                                onClick={handleClickShowPassword}
                                onMouseDown={handleMouseDownPassword}
                                onMouseUp={handleMouseUpPassword}
                                edge="end"
                            >
                                {showPassword ? <VisibilityOff /> : <Visibility />}
                            </IconButton>
                        </InputAdornment>
                    }
                />
            }
        />
    );
}

export default FieldPassword;
