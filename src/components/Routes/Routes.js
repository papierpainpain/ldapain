import React from 'react';
import { Routes, Route } from 'react-router-dom';
import AuthRequire from '../Auth/AuthRequire';
import Home from '../../pages/Home/Home';
import Login from '../../pages/Auth/Login/Login';
import NoMatch from '../../pages/NoMatch';
import Users from '../../pages/Admin/Users/Users';
import UserAdd from '../../pages/Admin/UserAdd/UserAdd';
import Logout from '../../pages/Auth/Logout/Logout';
import ResetPassword from '../../pages/Auth/ResetPassword/ResetPassword';
import ChangePassword from '../../pages/Auth/ChangePassword/ChangePassword';
import UserDelete from '../../pages/Admin/UserDelete/UserDelete';

function AppRoutes() {
    return (
        <Routes>
            <Route path="/login" element={<Login />} />

            <Route
                path="/"
                element={
                    <AuthRequire>
                        <Home />
                    </AuthRequire>
                }
            />

            <Route
                path="/logout"
                element={
                    <AuthRequire>
                        <Logout />
                    </AuthRequire>
                }
            />

            <Route path="/reset-password" element={<ResetPassword />} />

            <Route
                path="/change-password"
                element={
                    <AuthRequire>
                        <ChangePassword />
                    </AuthRequire>
                }
            />

            <Route path="/users">
                <Route
                    path=""
                    element={
                        <AuthRequire requireRoles={['admin']}>
                            <Users />
                        </AuthRequire>
                    }
                />
                <Route
                    path="add"
                    element={
                        <AuthRequire requireRoles={['admin']}>
                            <UserAdd />
                        </AuthRequire>
                    }
                />
                <Route
                    path="delete/:uid"
                    element={
                        <AuthRequire requireRoles={['admin']}>
                            <UserDelete />
                        </AuthRequire>
                    }
                />
            </Route>

            <Route path="*" element={<NoMatch />} />
        </Routes>
    );
}

export default AppRoutes;
