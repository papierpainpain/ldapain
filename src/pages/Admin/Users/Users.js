import { useState, useEffect, useContext } from 'react';
import UsersService from '../../../services/users.service';
import AuthContext from '../../../components/Auth/AuthContext';
import Header from '../../../components/Parts/Header/Header';
import {
    Checkbox,
    Table,
    TableBody,
    TableCell,
    TableRow,
} from '@mui/material';
import TableHeader from './TableHeader/TableHeader';

const Users = () => {
    const { token } = useContext(AuthContext);
    const [users, setUsers] = useState([]);

    useEffect(() => {
        UsersService.getAllUsers(token)
            .then((users) => setUsers(users))
            .catch((error) => console.log(error));
    }, [token]);

    return (
        <div className="mainContainer">
            <Header />

            <main className="profile">
                <h1>Users</h1>

                <section>
                    <div className="block">
                        <Table>
                            <TableHeader />

                            <TableBody>
                                {users.map((user) => (
                                    <TableRow key={user.uid}>
                                        <TableCell padding="checkbox">
                                            <Checkbox color="primary" />
                                        </TableCell>
                                        <TableCell>
                                            {user.uid}
                                        </TableCell>
                                        <TableCell>
                                            {user.sn}
                                        </TableCell>
                                        <TableCell>
                                            {user.cn}
                                        </TableCell>
                                        <TableCell>
                                            {user.mail}
                                        </TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    </div>
                </section>
            </main>
        </div>
    );
};

export default Users;
