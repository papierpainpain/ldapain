import LoginForm from './LoginForm/LoginForm';
import LayoutNotAuth from '../../../components/Parts/LayoutNotAuth/LayoutNotAuth';

const Login = () => {
    return (
        <LayoutNotAuth title='Connexion'>
            <LoginForm />
        </LayoutNotAuth>
    );
};

export default Login;
