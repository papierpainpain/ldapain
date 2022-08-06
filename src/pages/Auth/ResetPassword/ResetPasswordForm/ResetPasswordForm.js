import React, { useContext } from 'react';
import { useForm } from 'react-hook-form';
import { Link, useNavigate, useLocation } from 'react-router-dom';
import './ResetPasswordForm.css';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faCircleUser } from '@fortawesome/free-solid-svg-icons';
import AuthService from '../../../../services/auth.service';
import AuthContext from '../../../../components/Auth/AuthContext';

function ResetPasswordForm() {
    const { setMessage } = useContext(AuthContext);
    const {
        register,
        handleSubmit,
        formState: { errors },
        clearErrors,
    } = useForm();
    const navigate = useNavigate();
    const location = useLocation();

    const onSubmit = (data) => {
        AuthService.resetPassword(data.uid)
            .then(() => {
                setMessage({
                    type: 'success',
                    message: 'Un email vous a été envoyé pour réinitialiser votre mot de passe',
                });
                navigate(location.state?.from?.pathname || '/login');
            })
            .catch((error) => {
                setMessage({
                    type: 'danger',
                    message: error?.response?.data?.error || 'Cette erreur est inconnue donc RIP !',
                });
            });
    };

    return (
        <form onSubmit={handleSubmit(onSubmit)}>
            <FontAwesomeIcon icon={faCircleUser} className="profileIcon" />

            <div>
                <label className="sr-only" htmlFor="uid">
                    UID
                </label>
                <input
                    type="text"
                    name="uid"
                    id="uid"
                    placeholder="UID"
                    {...register('uid', {
                        required: 'Veuillez entrer votre UID',
                        minLength: {
                            value: 3,
                            message: 'Votre UID doit faire au moins 3 caractères',
                        },
                        type: 'text',
                    })}
                />
                {errors.uid && (
                    <p className="error">
                        {errors.uid.message || 'Erreur inconnue, veuillez réessayer'}
                    </p>
                )}
            </div>

            <Link to="/login" className="resetPwd">
                Ah non... Je m'en rappelle ! <span>›</span>
            </Link>

            <button type="submit" className="button" onClick={() => clearErrors()}>
                Réinitialiser
            </button>
        </form>
    );
}

export default ResetPasswordForm;
