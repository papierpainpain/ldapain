import HeaderLogo from './HeaderLogo/HeaderLogo';
import HeaderNav from './HeaderNav/HeaderNav';
import './Header.css';
import { useContext } from 'react';
import AuthContext from '../../Auth/AuthContext';
import { Link } from 'react-router-dom';

const Header = () => {
    const { isMobile } = useContext(AuthContext);

    return (
        <header className={isMobile ? 'headerMobile' : 'headerDesktop'}>
            <HeaderLogo />

            {!isMobile ? <HeaderNav /> : null}

            <Link
                to="/logout"
                className="buttonLink"
                role="button"
            >
                Déconnexion
            </Link>
        </header>
    );
};

export default Header;
