import React from 'react';
import PropTypes from 'prop-types';
import { faArrowLeft, faArrowRight, faPlusCircle } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { Link } from 'react-router-dom';
import './UsersNav.css';

function UsersNav({ totalPages, page, setPage }) {
    UsersNav.propTypes = {
        totalPages: PropTypes.number.isRequired,
        page: PropTypes.number.isRequired,
        setPage: PropTypes.func.isRequired,
    };

    const previousPage = () => {
        if (page > 1) {
            setPage(page - 1);
        }
    };

    const nextPage = () => {
        if (page < totalPages) {
            setPage(page + 1);
        }
    };

    return (
        <div className="usersNav">
            <Link to="/users/add" className="userAddLink">
                <FontAwesomeIcon icon={faPlusCircle} fixedWidth className="addIcon" />
                <p>Nouvel utilisateur</p>
            </Link>

            <div className="usersArrowPage">
                <FontAwesomeIcon
                    icon={faArrowLeft}
                    fixedWidth
                    className="arrowIcon"
                    onClick={previousPage}
                />
                <p>
                    {page}/{totalPages}
                </p>
                <FontAwesomeIcon
                    icon={faArrowRight}
                    fixedWidth
                    className="arrowIcon"
                    onClick={nextPage}
                />
            </div>
        </div>
    );
}

export default UsersNav;
