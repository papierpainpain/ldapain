import React from 'react';
import './Message.css';
import { faCircleXmark } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

function Message({ type, message, onClick }) {
    return (
        <div className={`alert alert-${type}`} role="alert">
            <p>{message}</p>
            <FontAwesomeIcon icon={faCircleXmark} className="icon" onClick={onClick} />
        </div>
    );
}

export default Message;
