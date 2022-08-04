import React from 'react';
import { useForm } from 'react-hook-form';
import { Link, useNavigate, useLocation } from 'react-router-dom';
import './ResetPasswordForm.css';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faCircleUser } from '@fortawesome/free-solid-svg-icons';
import Message from '../../../../components/Parts/Message/Message';
import AuthService from '../../../../services/auth.service';

function ResetPasswordForm() {
    const {
        register,
        handleSubmit,
        formState: { errors },
        setError,
        clearErrors,
    } = useForm();
    const navigate = useNavigate();
    const location = useLocation();

    const onSubmit = (data) => {
        clearErrors();
        AuthService.resetPassword(data.uid)
            .then(() => {
                navigate(location.state?.from?.pathname || '/login');
            })
            .catch((error) => {
                setError('all', {
                    type: 'auth',
                    message: error?.response?.data?.error || 'Cette erreur est inconnue donc RIP !',
                });
            });
    };

    return (
        <>
            {errors.all && (
                <Message
                    type="danger"
                    message={errors.all.message}
                    clearMessage={() => clearErrors()}
                />
            )}
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
        </>
    );
}

export default ResetPasswordForm;
