import React, { useContext, useState } from 'react';
import './UserAddForm.css';
import { useForm } from 'react-hook-form';
import { useLocation, useNavigate } from 'react-router-dom';
import AuthContext from '../../../../components/Auth/AuthContext';
import UsersService from '../../../../services/users.service';
import Message from '../../../../components/Parts/Message/Message';

function UserAddForm() {
    const { token } = useContext(AuthContext);
    const navigate = useNavigate();
    const location = useLocation();
    const {
        register,
        handleSubmit,
        formState: { errors },
        setError,
        clearErrors,
    } = useForm({
        defaultValues: {
            uid: '',
            sn: '',
            cn: '',
            mail: '',
        },
    });
    const [success, setSuccess] = useState(null);

    const onSubmit = (user) => {
        UsersService.createUser(token, user)
            .then(() => {
                setSuccess('Utilisateur créé !');
                navigate(location.state?.from?.pathname || '/users');
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
                <Message type="danger" message={errors.all.message} onClick={() => clearErrors()} />
            )}

            {success && (
                <Message type="success" message={success} onClick={() => setSuccess(null)} />
            )}

            <form onSubmit={handleSubmit(onSubmit)} className="userAddForm">
                <div className="row">
                    <div className="item">
                        <label htmlFor="sn" className="itemTitle">
                            Prénom
                        </label>
                        <input
                            type="text"
                            id="sn"
                            name="sn"
                            placeholder="Prénom"
                            className="itemContent"
                            {...register('sn', {
                                required: 'Veuillez entrer le prénom',
                                minLength: {
                                    value: 2,
                                    message: 'Le prénom doit faire au moins 2 caractères',
                                },
                                type: 'text',
                            })}
                        />
                        {errors?.sn && (
                            <p className="error">
                                {errors.sn.message || 'Erreur inconnue, veuillez réessayer'}
                            </p>
                        )}
                    </div>
                    <div className="item">
                        <label htmlFor="cn" className="itemTitle">
                            Nom
                        </label>
                        <input
                            type="text"
                            id="cn"
                            name="cn"
                            placeholder="Nom"
                            className="itemContent"
                            {...register('cn', {
                                required: 'Veuillez entrer le nom',
                                minLength: {
                                    value: 2,
                                    message: 'Le nom doit faire au moins 2 caractères',
                                },
                                type: 'text',
                            })}
                        />
                        {errors?.cn && (
                            <p className="error">
                                {errors.cn.message || 'Erreur inconnue, veuillez réessayer'}
                            </p>
                        )}
                    </div>
                </div>

                <div className="row">
                    <div className="item">
                        <label htmlFor="uid" className="itemTitle">
                            Uid
                        </label>
                        <input
                            type="text"
                            id="uid"
                            name="uid"
                            placeholder="Uid"
                            className="itemContent"
                            {...register('uid', {
                                required: "Veuillez entrer l'uid",
                                minLength: {
                                    value: 2,
                                    message: "L'uid doit faire au moins 2 caractères",
                                },
                                type: 'text',
                            })}
                        />
                        {errors?.uid && (
                            <p className="error">
                                {errors.uid.message || 'Erreur inconnue, veuillez réessayer'}
                            </p>
                        )}
                    </div>
                    <div className="item">
                        <label htmlFor="mail" className="itemTitle">
                            Email
                        </label>
                        <input
                            type="mail"
                            id="mail"
                            name="mail"
                            placeholder="Email"
                            className="itemContent"
                            {...register('mail', {
                                required: "Veuillez entrer l'email",
                                pattern: {
                                    value: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i,
                                    message: "L'email n'est pas valide",
                                },
                                type: 'email',
                            })}
                        />
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
}

export default UserAddForm;
