import { useContext } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import AuthContext from '../../../components/Auth/AuthContext';
import Layout from '../../../components/Parts/Layout/Layout';
import UsersService from '../../../services/users.service';
import './UserDelete.css';

const UserDelete = () => {
    const { token } = useContext(AuthContext);
    const navigate = useNavigate();
    const { uid } = useParams();

    const deleteUser = () => {
        UsersService.deleteUser(token, uid)
            .then(() => {
                navigate('/users');
            })
            .catch((error) => console.log(error));
    };

    return (
        <Layout title="Suppression de l'utilisateur">
            <p>
                Êtes-vous sûr de vouloir supprimer l'utilisateur{' '}
                <b>{uid}</b> ?
            </p>

            <div className="userDeleteContainer">
                <button
                    className="btn btn-danger"
                    onClick={() => deleteUser()}
                >
                    Supprimer l'utilisateur {uid}
                </button>
                <button
                    className="btn btn-secondary"
                    onClick={() => navigate('/users')}
                >
                    Retour
                </button>
            </div>
        </Layout>
    );
};

export default UserDelete;
