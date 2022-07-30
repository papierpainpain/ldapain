import { Route } from 'react-router-dom';
import Users from '../../pages/Users/Users';

const UsersRoutes = () => {
    return (
        <Route path="" element={<Users />}>
            {/* <Route path="add" element={<UsersAdd />} /> */}
            {/* <Route path=":id" element={<UsersProfile />} /> */}
            {/* <Route path=":id/edit" element={<UsersEdit />} /> */}
            {/* <Route path=":id/delete" element={<UsersDelete />} /> */}
        </Route>
    );
};

export default UsersRoutes;
