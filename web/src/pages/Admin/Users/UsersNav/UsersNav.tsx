import React from 'react'
import { faArrowLeft, faArrowRight, faPlusCircle } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { Link } from 'react-router-dom'
import './UsersNav.css'

interface UsersNavProps {
  totalPages: number
  page: number
  setPage: (page: number) => void
}

function UsersNav(props: UsersNavProps) {
  const previousPage = () => {
    if (props.page > 1) {
      props.setPage(props.page - 1)
    }
  }

  const nextPage = () => {
    if (props.page < props.totalPages) {
      props.setPage(props.page + 1)
    }
  }

  return (
    <div className='usersNav'>
      <Link to='/users/add' className='userAddLink'>
        <FontAwesomeIcon icon={faPlusCircle} fixedWidth className='addIcon' />
        <p>Nouvel utilisateur</p>
      </Link>

      <div className='usersArrowPage'>
        <FontAwesomeIcon
          icon={faArrowLeft}
          fixedWidth
          className='arrowIcon'
          onClick={previousPage}
        />
        <p>
          {props.page}/{props.totalPages}
        </p>
        <FontAwesomeIcon icon={faArrowRight} fixedWidth className='arrowIcon' onClick={nextPage} />
      </div>
    </div>
  )
}

export default UsersNav
