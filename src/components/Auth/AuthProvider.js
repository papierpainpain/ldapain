import React, { useEffect, useState } from 'react';
import PropTypes from 'prop-types';
import AuthContext from './AuthContext';
import useAuth from '../../hooks/useAuth';

function AuthProvider({ children }) {
    AuthProvider.propTypes = {
        children: PropTypes.node.isRequired,
    };

    const { token, setToken, auth, role } = useAuth();
    const [message, setMessage] = useState(null);
    const [isMobile, setIsMobile] = useState(window.innerWidth < 1200);

    useEffect(() => {
        window.addEventListener(
            'resize',
            () => {
                setIsMobile(window.innerWidth < 950);
            },
            [isMobile],
        );
    }, [isMobile, setIsMobile]);

    return (
        <AuthContext.Provider
            // eslint-disable-next-line react/jsx-no-constructed-context-values
            value={{
                token,
                setToken,
                auth,
                role,
                message,
                setMessage,
                isMobile,
            }}
        >
            {children}
        </AuthContext.Provider>
    );
}

export default AuthProvider;
