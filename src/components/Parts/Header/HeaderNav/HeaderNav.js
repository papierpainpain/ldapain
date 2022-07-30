import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import {
    faHouse,
    faUsers,
    faPeopleRoof,
    faKey,
} from '@fortawesome/free-solid-svg-icons';
import { Link } from 'react-router-dom';
import './HeaderNav.css';
import useRole from '../../../../hooks/useRole';

const HeaderNav = () => {
    const isAdmin = useRole('admin');

    return (
        <ul className="navHeader">
            <li>
                <Link to="/" className="navA">
                    <FontAwesomeIcon icon={faHouse} fixedWidth />
                    <p>Accueil</p>
                </Link>
            </li>

            <li>
                <Link to="/change-password" className="navA">
                    <FontAwesomeIcon icon={faKey} fixedWidth />
                    <p>Changer mon mot de passe</p>
                </Link>
            </li>

            {isAdmin && (
                <li>
                    <Link to="/users" className="navA">
                        <FontAwesomeIcon icon={faUsers} fixedWidth />
                        <p>Utilisateurs</p>
                    </Link>
                </li>
            )}

            {isAdmin && (
                <li>
                    <Link to="/groups" className="navA">
                        <FontAwesomeIcon
                            icon={faPeopleRoof}
                            fixedWidth
                        />
                        <p>Groupes</p>
                    </Link>
                </li>
            )}
        </ul>
    );
};

export default HeaderNav;
