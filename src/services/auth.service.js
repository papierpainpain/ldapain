import axios from 'axios';

const BASE_URL = "/api/";

const login = async (uid, password) => {
    const response = await axios({
        method: 'post',
        url: BASE_URL + 'token',
        data: {
            uid: uid,
            password: password,
        },
        headers: { 'Content-Type': 'application/json' },
    });

    return response.data;
};

const updateProfile = async (token, firstname, lastname) => {
    const response = await axios({
        method: 'put',
        url: BASE_URL + 'profile',
        data: {
            cn: lastname,
            sn: firstname,
        },
        headers: {
            'Content-Type': 'application/json',
            Authorization: `Bearer ${token}`,
        },
    });

    return response.data;
};

const logout = () => {
    localStorage.removeItem('token');
};

const resetPassword = async (uid) => {
    const response = await axios({
        method: 'put',
        url: BASE_URL + 'profile/password/reset',
        data: {
            uid: uid,
        },
        headers: { 'Content-Type': 'application/json' },
    });

    return response.data;
};

const updatePassword = async (token, oldPassword, newPassword) => {
    const response = await axios({
        method: 'put',
        url: BASE_URL + 'profile/password',
        data: {
            oldPassword: oldPassword,
            newPassword: newPassword,
        },
        headers: {
            'Content-Type': 'application/json',
            Authorization: `Bearer ${token}`,
        },
    });

    return response.data;
};

const AuthService = {
    login,
    updateProfile,
    logout,
    resetPassword,
    updatePassword,
};

export default AuthService;
