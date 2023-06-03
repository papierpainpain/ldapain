import React from 'react'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faCircleUser } from '@fortawesome/free-solid-svg-icons'
import './ProfileHeader.css'
import ITypeUser from '../../../types/ITypeUser'

interface ProfileHeaderProps {
  user: ITypeUser
}

function ProfileHeader(props: ProfileHeaderProps) {
  return (
    <div className='profileTop'>
      <FontAwesomeIcon icon={faCircleUser} className='profileIcon' />
      <div className='profileContent'>
        <h2>{props.user.uid}</h2>
        <p>{props.user.dn}</p>
        <span>Osef mais le chef voulait</span>
      </div>
    </div>
  )
}

export default ProfileHeader
