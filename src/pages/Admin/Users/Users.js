import React, { useState, useEffect, useContext } from 'react';
import UsersService from '../../../services/users.service';
import AuthContext from '../../../components/Auth/AuthContext';
import Layout from '../../../components/Parts/Layout/Layout';
import UsersTable from './UsersTable/UsersTable';
import UsersNav from './UsersNav/UsersNav';
import Message from '../../../components/Parts/Message/Message';

function Users() {
    const { token } = useContext(AuthContext);
    const [users, setUsers] = useState([]);
    const [page, setPage] = useState(1);
    const [totalPages, setTotalPages] = useState(1);
    const [error, setError] = useState(null);

    useEffect(() => {
        UsersService.getAllUsers(token)
            .then((usersList) => {
                setUsers(usersList);
                setPage(1);
                setTotalPages(Math.ceil(usersList.length / 8));
            })
            .catch((e) => setError(e.response.data));
    }, [token]);

    return (
        <Layout title="Utilisateurs">
            {error && <Message type="danger" message={error} onClick={() => setError(null)} />}
            <UsersNav totalPages={totalPages} page={page} setPage={setPage} />

            <UsersTable users={users} page={page} />
        </Layout>
    );
}

export default Users;
