import React from 'react';
import { BrowserRouter } from 'react-router-dom';
import AppRoutes from '../Routes/Routes';
import AuthProvider from '../Auth/AuthProvider';

const App = () => {
    return (
        <BrowserRouter>
            <AuthProvider>
                <AppRoutes />
            </AuthProvider>
        </BrowserRouter>
    );
};

export default App;
