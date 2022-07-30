import AuthContext from './AuthContext';
import useAuth from '../../hooks/useAuth';
import { useEffect, useState } from 'react';

const AuthProvider = ({ children }) => {
    const { token, setToken, auth, role } = useAuth();
    const [isMobile, setIsMobile] = useState(
        window.innerWidth < 1200
    );

    useEffect(() => {
        window.addEventListener(
            'resize',
            () => {
                setIsMobile(window.innerWidth < 950);
            },
            [isMobile]
        );
    }, [isMobile, setIsMobile]);

    return (
        <AuthContext.Provider
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
};

export default AuthProvider;
