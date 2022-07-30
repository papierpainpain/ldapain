import './Profile.css';
import { useForm } from 'react-hook-form';
import { Link } from 'react-router-dom';
import { useContext, useState } from 'react';
import AuthContext from '../../../components/Auth/AuthContext';
import jwtDecode from 'jwt-decode';
import AuthService from '../../../services/auth.service';
import ProfileHeader from '../../../components/Parts/ProfileHeader/ProfileHeader';
import Message from '../../../components/Parts/Message/Message';

const Profile = () => {
    const { token, setToken } = useContext(AuthContext);
    const [user, setUser] = useState(
        token ? jwtDecode(token).data : null
    );
    const {
        register,
        handleSubmit,
        formState: { errors },
        setError,
        clearErrors,
    } = useForm({
        defaultValues: {
            firstname: user?.sn || '',
            lastname: user?.cn || '',
            email: user?.mail || '',
        },
    });
    const [success, setSuccess] = useState(null);

    const onSubmit = (data) => {
        AuthService.updateProfile(
            token,
            data.firstname,
            data.lastname
        )
            .then((userToken) => {
                setToken(userToken.token);
                setUser(jwtDecode(userToken.token).data);
                setSuccess('Profil mis à jour !');
            })
            .catch((error) => {
                setError('all', {
                    type: 'auth',
                    message:
                        error?.response?.data?.error ||
                        'Cette erreur est inconnue donc RIP !',
                });
            });
    };

    return (
        <>
            {errors.all && (
                <Message
                    type="danger"
                    message={errors.all.message}
                    onClick={() => clearErrors()}
                />
            )}

            {success && (
                <Message
                    type="success"
                    message={success}
                    onClick={() => setSuccess(null)}
                />
            )}

            <ProfileHeader user={user} />

            <form
                onSubmit={handleSubmit(onSubmit)}
                className="profileForm"
            >
                <div className="row">
                    <div className="item">
                        <label
                            htmlFor="firstname"
                            className="itemTitle"
                        >
                            Prénom
                        </label>
                        <input
                            type="text"
                            id="firstname"
                            name="firstname"
                            placeholder="Prénom"
                            className="itemContent"
                            {...register('firstname', {
                                required:
                                    'Veuillez entrer votre prénom',
                                minLength: {
                                    value: 2,
                                    message:
                                        'Votre prénom doit faire au moins 2 caractères',
                                },
                                type: 'text',
                            })}
                        />
                        {errors?.firstname && (
                            <p className="error">
                                {errors.firstname.message ||
                                    'Erreur inconnue, veuillez réessayer'}
                            </p>
                        )}
                    </div>
                    <div className="item">
                        <label
                            htmlFor="lastname"
                            className="itemTitle"
                        >
                            Nom
                        </label>
                        <input
                            type="text"
                            id="lastname"
                            name="lastname"
                            placeholder="Nom"
                            className="itemContent"
                            {...register('lastname', {
                                required: 'Veuillez entrer votre nom',
                                minLength: {
                                    value: 2,
                                    message:
                                        'Votre nom doit faire au moins 2 caractères',
                                },
                                type: 'text',
                            })}
                        />
                        {errors?.lastname && (
                            <p className="error">
                                {errors.lastname.message ||
                                    'Erreur inconnue, veuillez réessayer'}
                            </p>
                        )}
                    </div>
                </div>

                <div className="row">
                    <div className="item">
                        <label htmlFor="email" className="itemTitle">
                            Email
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            className="itemContent"
                            {...register('email', {
                                required:
                                    'Veuillez entrer votre email',
                                pattern: {
                                    value: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i,
                                    message:
                                        "Votre email n'est pas valide",
                                },
                                type: 'email',
                                disabled: true,
                            })}
                        />
                    </div>
                    <div className="item">
                        <p className="itemTitle">Mot de passe</p>
                        <Link
                            to="/change-password"
                            className="itemContent button"
                        >
                            Changer le mot de passe ›
                        </Link>
                    </div>
                </div>

                <button
                    type="submit"
                    className="submit"
                    onClick={() => clearErrors() && setSuccess(null)}
                >
                    Enregistrer
                </button>
            </form>
        </>
    );
};

export default Profile;
