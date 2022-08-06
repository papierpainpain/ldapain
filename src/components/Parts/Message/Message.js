import React, { useEffect } from 'react';
import PropTypes from 'prop-types';
import './Message.css';
import { faCircleXmark } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

function Message({ type, message, setMessage }) {
    Message.propTypes = {
        type: PropTypes.string.isRequired,
        message: PropTypes.string.isRequired,
        setMessage: PropTypes.func.isRequired,
    };

    useEffect(() => {
        setTimeout(() => setMessage(null), 5000);
    }, [setMessage]);

    const handleClose = () => {
        setMessage(null);
    };

    return (
        <div className={`alert alert-${type}`} role="alert">
            <p>{message}</p>
            <FontAwesomeIcon icon={faCircleXmark} className="icon" onClick={handleClose} />
        </div>
    );
}

export default Message;
