import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { Link } from 'react-router-dom';
import './ActionLink.css';

const ActionLink = ({ url, icon }) => {
    return (
        <Link
            to={url}
            className="userActionLink"
        >
            <FontAwesomeIcon
                icon={icon}
                fixedWidth
                className="actionIcon"
            />
        </Link>
    );
};

export default ActionLink;
