import React from 'react';
import PropTypes from 'prop-types';
import RegisterForm from '../RegisterForm';

Register.propTypes = {
    handleClose: PropTypes.func
};

function Register({ handleClose }) {
    const handleSubmit = (values) => {
        console.log(values)
    }
    return (
        <div>
            <RegisterForm handleClose={handleClose} onSubmit={handleSubmit} />
        </div>
    );
}

export default Register;