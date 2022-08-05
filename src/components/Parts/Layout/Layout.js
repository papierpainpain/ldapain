import React from 'react';
import PropTypes from 'prop-types';
import './Layout.css';
import Header from '../Header/Header';

function Layout({ title, children }) {
    Layout.propTypes = {
        title: PropTypes.string.isRequired,
        children: PropTypes.node.isRequired,
    };

    return (
        <div className="mainContainer">
            <Header />

            <main>
                <h1>{title}</h1>

                <section>
                    <div className="block">{children}</div>
                </section>
            </main>
        </div>
    );
}

export default Layout;
