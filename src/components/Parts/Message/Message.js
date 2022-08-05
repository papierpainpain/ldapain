import React from 'react';
import PropTypes from 'prop-types';
import './Message.css';
import { faCircleXmark } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

function Message({ type, message, onClick }) {
    Message.propTypes = {
        type: PropTypes.string.isRequired,
        message: PropTypes.string.isRequired,
        onClick: PropTypes.func.isRequired,
    };

    return (
        <div className={`alert alert-${type}`} role="alert">
            <p>{message}</p>
            <FontAwesomeIcon icon={faCircleXmark} className="icon" onClick={onClick} />
        </div>
    );
}

export default Message;
