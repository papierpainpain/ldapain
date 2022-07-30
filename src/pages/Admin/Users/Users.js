import { useState, useEffect, useContext } from 'react';
import UsersService from '../../../services/users.service';
import AuthContext from '../../../components/Auth/AuthContext';
import Layout from '../../../components/Parts/Layout/Layout';
import UsersTable from './UsersTable/UsersTable';
import UsersNav from './UsersNav/UsersNav';

const Users = () => {
    const { token } = useContext(AuthContext);
    const [users, setUsers] = useState([]);
    const [page, setPage] = useState(1);
    const [totalPages, setTotalPages] = useState(1);

    useEffect(() => {
        UsersService.getAllUsers(token)
            .then((users) => {
                setUsers(users);
                setPage(1);
                setTotalPages(Math.ceil(users.length / 8));
            })
            .catch((error) => console.log(error));
    }, [token]);

    return (
        <Layout title="Users">
            <UsersNav totalPages={totalPages} page={page} setPage={setPage} />

            <UsersTable users={users} page={page} />
        </Layout>
    );
};

export default Users;
