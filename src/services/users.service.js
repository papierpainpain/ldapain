import axios from 'axios';
import AuthService from './auth.service';

const BASE_URL = '/api/users/';

const headers = (token) => ({
    headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${token}`,
    },
});

const getAllUsers = async (token) => {
    const response = await axios.get(BASE_URL, headers(token));
    if (response.status === 403) {
        AuthService.logout();
    }
    return response.data;
};

const getUserById = async (token, id) => {
    const response = await axios.get(BASE_URL + id, headers(token));
    return response.data;
};

const createUser = async (token, user) => {
    const response = await axios.post(BASE_URL, user, headers(token));
    return response.data;
};

const updateUser = async (token, user) => {
    const response = await axios.put(BASE_URL + user.id, user, headers(token));
    return response.data;
};

const deleteUser = async (token, uid) => {
    const response = await axios.delete(BASE_URL + uid, headers(token));
    return response.data;
};

const UsersService = {
    getAllUsers,
    getUserById,
    createUser,
    updateUser,
    deleteUser,
};

export default UsersService;
