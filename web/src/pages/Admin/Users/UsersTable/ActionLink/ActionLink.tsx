import React from 'react'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { Link } from 'react-router-dom'
import './ActionLink.css'
import { IconDefinition } from '@fortawesome/fontawesome-svg-core'

interface ActionLinkProps {
  url: string
  icon: IconDefinition
}

function ActionLink(props: ActionLinkProps) {
  return (
    <Link to={props.url} className='userActionLink'>
      <FontAwesomeIcon icon={props.icon} fixedWidth className='actionIcon' />
    </Link>
  )
}

export default ActionLink
