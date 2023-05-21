import React from 'react'
import PropTypes from 'prop-types'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { Link } from 'react-router-dom'
import './ActionLink.css'

function ActionLink({ url, icon }) {
  ActionLink.propTypes = {
    url: PropTypes.string.isRequired,
    // eslint-disable-next-line react/forbid-prop-types
    icon: PropTypes.object.isRequired
  }

  return (
    <Link to={url} className="userActionLink">
      <FontAwesomeIcon icon={icon} fixedWidth className="actionIcon" />
    </Link>
  )
}

export default ActionLink
