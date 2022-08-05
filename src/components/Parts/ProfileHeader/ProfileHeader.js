import React from 'react';
import PropTypes from 'prop-types';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faCircleUser } from '@fortawesome/free-solid-svg-icons';
import './ProfileHeader.css';

function ProfileHeader({ user }) {
    ProfileHeader.propTypes = {
        user: PropTypes.shape({
            uid: PropTypes.string.isRequired,
            dn: PropTypes.string.isRequired,
        }).isRequired,
    };

    return (
        <div className="profileTop">
            <FontAwesomeIcon icon={faCircleUser} className="profileIcon" />
            <div className="profileContent">
                <h2>{user.uid}</h2>
                <p>{user.dn}</p>
                <span>Osef mais le chef voulait</span>
            </div>
        </div>
    );
}

export default ProfileHeader;
