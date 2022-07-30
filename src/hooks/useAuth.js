import { useState } from 'react';
import jwtDecode from 'jwt-decode';

const useAuth = () => {
    const getTokenFromStorage = () => {
        const storageToken = localStorage.getItem('token');
        if (storageToken?.length && storageToken !== 'undefined') {
            return storageToken;
        }
        return null;
    };

    const getToken = () => {
        const tokenFS = getTokenFromStorage();
        if (
            tokenFS &&
            !(jwtDecode(tokenFS).exp <= Date.now() / 1000)
        ) {
            return tokenFS;
        }
        localStorage.removeItem('token');
        return null;
    };

    const [token, setToken] = useState(getToken());
    const [auth, setAuth] = useState(token ? true : false);
    const [role, setRole] = useState(token ? jwtDecode(token).data.groups : null);

    const saveToken = (token) => {
        if (token) {
            localStorage.setItem('token', token);
            setToken(token);
            setAuth(true);
            setRole(jwtDecode(token).data.groups);
        } else {
            localStorage.removeItem('token');
            setToken(null);
            setAuth(false);
            setRole(null);
        }
    };

    return { token, setToken: saveToken, auth, role };
};

export default useAuth;
