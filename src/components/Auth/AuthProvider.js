import React, { useEffect, useState } from 'react';
import AuthContext from './AuthContext';
import useAuth from '../../hooks/useAuth';

function AuthProvider({ children }) {
    const { token, setToken, auth, role } = useAuth();
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
                isMobile,
            }}
        >
            {children}
        </AuthContext.Provider>
    );
}

export default AuthProvider;
