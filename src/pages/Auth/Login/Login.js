import React from 'react';
import LoginForm from './LoginForm/LoginForm';
import LayoutNotAuth from '../../../components/Parts/LayoutNotAuth/LayoutNotAuth';

function Login() {
    return (
        <LayoutNotAuth title="Connexion">
            <LoginForm />
        </LayoutNotAuth>
    );
}

export default Login;
