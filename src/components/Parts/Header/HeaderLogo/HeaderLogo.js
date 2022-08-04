import React from 'react';
import logo from './papierpain.png';
import './HeaderLogo.css';
import Title from '../../Title/Title';

function HeaderLogo() {
    return (
        <div className="headerLogo">
            <figure className="figure">
                <img src={logo} alt="Logo PapierPain Lab" className="image" />
                <figcaption className="caption">
                    <Title />
                </figcaption>
            </figure>
        </div>
    );
}

export default HeaderLogo;
