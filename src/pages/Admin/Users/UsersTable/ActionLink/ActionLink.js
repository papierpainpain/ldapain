import React from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { Link } from 'react-router-dom';
import './ActionLink.css';

function ActionLink({ url, icon }) {
    return (
        <Link to={url} className="userActionLink">
            <FontAwesomeIcon icon={icon} fixedWidth className="actionIcon" />
        </Link>
    );
}

export default ActionLink;
