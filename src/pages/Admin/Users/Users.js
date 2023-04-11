import React, { useState, useEffect, useContext } from 'react';
import UsersService from '../../../services/users.service';
import AuthContext from '../../../components/Auth/AuthContext';
import Layout from '../../../components/Parts/Layout/Layout';
import UsersTable from './UsersTable/UsersTable';
import UsersNav from './UsersNav/UsersNav';

function Users() {
    const { token, setMessage } = useContext(AuthContext);
    const [users, setUsers] = useState([]);
    const [page, setPage] = useState(1);
    const [totalPages, setTotalPages] = useState(1);

    useEffect(() => {
        UsersService.getAllUsers(token)
            .then((usersList) => {
                setUsers(usersList);
                setPage(1);
                setTotalPages(Math.ceil(usersList.length / 8));
            })
            .catch((e) => setMessage({ type: 'danger', message: e.response.data }));
    }, [token, setMessage]);

    return (
        <Layout title="Utilisateurs">
            <UsersNav totalPages={totalPages} page={page} setPage={setPage} />

            <UsersTable users={users} page={page} />
        </Layout>
    );
}

export default Users;
