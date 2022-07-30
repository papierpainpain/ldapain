import { Navigate, useLocation } from 'react-router-dom';
import AuthContext from './AuthContext';
import { useContext } from 'react';

const AuthRequire = ({ requireRoles = [], children }) => {
    const { auth, role } = useContext(AuthContext);
    const location = useLocation();

    const hasRoles = () => {
        if (requireRoles.length === 0) {
            return true;
        }
        return requireRoles.some((r) => role.includes(r));
    };

    return (
        <>
            {auth && hasRoles() ? (
                children
            ) : auth ? (
                <Navigate to="/" />
            ) : (
                <Navigate
                    to="/login"
                    replace
                    state={{ from: location }}
                />
            )}
        </>
    );
};

export default AuthRequire;
