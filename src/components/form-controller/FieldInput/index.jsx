import { PropTypes } from 'prop-types';
import { TextField } from '@mui/material';
import { Controller } from 'react-hook-form';

FieldInput.propTypes = {
    name: PropTypes.string.isRequired,
    form: PropTypes.object.isRequired,
    placeholder: PropTypes.string,
    type: PropTypes.string,
}

function FieldInput(props) {
    const { name, placeholder, type, form } = props
    const { errors } = form.formState
    return (
        <Controller
            name={name}
            control={form.control}
            render={({ field }) => <TextField size='small' error={!!errors[name]} helperText={errors[name]?.message} sx={{ mb: 1, mt: 1, background: "#f2f2f2" }} placeholder={placeholder} fullWidth variant='outlined' type={type} {...field}></TextField>}
        />
    )
}

export default FieldInput;