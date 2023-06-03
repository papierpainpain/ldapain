import React, { useContext } from 'react'
import { useNavigate, useParams } from 'react-router-dom'
import AuthContext from '../../../components/Auth/AuthContext'
import Layout from '../../../components/Parts/Layout/Layout'
import UsersService from '../../../services/users.service'
import './UserDelete.css'

function UserDelete() {
  const { token, setMessage } = useContext(AuthContext)
  const navigate = useNavigate()
  const { uid } = useParams()

  const deleteUser = () => {
    UsersService.deleteUser(token as string, uid as string)
      .then(() => {
        setMessage({
          type: 'success',
          message: 'Utilisateur supprimé avec succès',
        })
        navigate('/users')
      })
      .catch((e) =>
        setMessage({
          type: 'danger',
          message: e.response.data,
        }),
      )
  }

  return (
    <Layout title="Suppression de l'utilisateur">
      <p>
        Êtes-vous sûr de vouloir supprimer l&apos;utilisateur <b>{uid}</b> ?
      </p>

      <div className='userDeleteContainer'>
        <button type='button' className='btn btn-danger' onClick={() => deleteUser()}>
          Supprimer l&apos;utilisateur {uid}
        </button>
        <button type='button' className='btn btn-secondary' onClick={() => navigate('/users')}>
          Retour
        </button>
      </div>
    </Layout>
  )
}

export default UserDelete
