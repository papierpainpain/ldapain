import ResetPasswordForm from './ResetPasswordForm/ResetPasswordForm';
import LayoutNotAuth from '../../../components/Parts/LayoutNotAuth/LayoutNotAuth';

const ResetPassword = () => {
    return (
        <LayoutNotAuth title='GPerduMonMdp'>
            <ResetPasswordForm />
        </LayoutNotAuth>
    );
};

export default ResetPassword;