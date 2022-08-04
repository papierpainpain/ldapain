import React from 'react';
import Gif2Pika from '../Gif2Pika/Gif2Pika';
import LogoHeader from './LogoHeader/LogoHeader';
import './LayoutNotAuth.css';

function LayoutNotAuth({ title, children }) {
    return (
        <div className="notAuthContainer">
            <LogoHeader />

            <main>
                <div className="container">
                    <section className="secForm">
                        <div className="box">
                            <h1>{title}</h1>

                            {children}
                        </div>
                    </section>

                    <Gif2Pika />
                </div>
            </main>
        </div>
    );
}

export default LayoutNotAuth;
