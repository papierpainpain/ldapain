import React from 'react'
import PropTypes from 'prop-types'
import { faArrowRotateForward, faTrash } from '@fortawesome/free-solid-svg-icons'
import ActionLink from './ActionLink/ActionLink'
import TableHeader from './TableHeader/TableHeader'
import './UsersTable.css'

function UsersTable({ users, page }) {
  UsersTable.propTypes = {
    users: PropTypes.arrayOf(
      PropTypes.shape({
        uid: PropTypes.string.isRequired,
        sn: PropTypes.string.isRequired,
        mail: PropTypes.string.isRequired
      })
    ).isRequired,
    page: PropTypes.number.isRequired
  }

  return (
    <div className="userTableContainer">
      <table className="table">
        <TableHeader />

        <tbody>
          {users.slice((page - 1) * 8, page * 8).map((user, index) => (
            <tr key={user.uid}>
              <th scope="row">{index + 1 + (page - 1) * 8}</th>
              <td>
                {user.uid} <i>({user.sn})</i>
              </td>
              <td>{user.mail}</td>
              <td className="actionList">
                <ActionLink url={`/users/reset-password/${user.uid}`} icon={faArrowRotateForward} />
                <ActionLink url={`/users/delete/${user.uid}`} icon={faTrash} />
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  )
}

export default UsersTable
