import React, { useContext, useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import AuthContext from '../../../components/Auth/AuthContext';
import Layout from '../../../components/Parts/Layout/Layout';
import UsersService from '../../../services/users.service';
import './UserDelete.css';
import Message from '../../../components/Parts/Message/Message';

function UserDelete() {
    const { token } = useContext(AuthContext);
    const navigate = useNavigate();
    const { uid } = useParams();
    const [error, setError] = useState(null);

    const deleteUser = () => {
        UsersService.deleteUser(token, uid)
            .then(() => {
                navigate('/users');
            })
            .catch((e) => setError(e.response.data));
    };

    return (
        <Layout title="Suppression de l'utilisateur">
            {error && <Message type="danger" message={error} onClick={() => setError(null)} />}

            <p>
                Êtes-vous sûr de vouloir supprimer l'utilisateur <b>{uid}</b> ?
            </p>

            <div className="userDeleteContainer">
                <button type="button" className="btn btn-danger" onClick={() => deleteUser()}>
                    Supprimer l'utilisateur {uid}
                </button>
                <button
                    type="button"
                    className="btn btn-secondary"
                    onClick={() => navigate('/users')}
                >
                    Retour
                </button>
            </div>
        </Layout>
    );
}

export default UserDelete;
