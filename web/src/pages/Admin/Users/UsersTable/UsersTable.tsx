import React from 'react'
import { faArrowRotateForward, faTrash } from '@fortawesome/free-solid-svg-icons'
import ActionLink from './ActionLink/ActionLink'
import TableHeader from './TableHeader/TableHeader'
import './UsersTable.css'
import ITypeUser from '../../../../types/ITypeUser'

interface UsersTableProps {
  users: ITypeUser[]
  page: number
}

function UsersTable(props: UsersTableProps) {
  return (
    <div className='userTableContainer'>
      <table className='table'>
        <TableHeader />

        <tbody>
          {props.users.slice((props.page - 1) * 8, props.page * 8).map((user, index) => (
            <tr key={user.uid}>
              <th scope='row'>{index + 1 + (props.page - 1) * 8}</th>
              <td>
                {user.uid} <i>({user.sn})</i>
              </td>
              <td>{user.mail}</td>
              <td className='actionList'>
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
