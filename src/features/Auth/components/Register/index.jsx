import PropTypes from 'prop-types';
import React from 'react';
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