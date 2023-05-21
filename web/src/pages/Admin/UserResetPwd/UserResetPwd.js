import React, { useContext } from 'react'
import { useNavigate, useParams } from 'react-router-dom'
import AuthContext from '../../../components/Auth/AuthContext'
import Layout from '../../../components/Parts/Layout/Layout'
import UsersService from '../../../services/users.service'
import './UserResetPwd.css'

function UserResetPwd() {
  const { token, setMessage } = useContext(AuthContext)
  const navigate = useNavigate()
  const { uid } = useParams()

  const resetPwdUser = () => {
    UsersService.resetPwdUser(token, uid)
      .then(() => {
        setMessage({
          type: 'success',
          message: 'Mot de passse réinitialisé !'
        })
        navigate('/users')
      })
      .catch((e) =>
        setMessage({
          type: 'danger',
          message: e // .response.data,
        })
      )
  }

  return (
    <Layout title="Réinitialisation du mot de passe">
      <p>
        Êtes-vous sûr de vouloir réinitialiser le mot de passe de <b>{uid}</b> ?
      </p>

      <div className="userResetPwdContainer">
        <button type="button" className="btn btn-danger" onClick={resetPwdUser}>
          Réinitialiser le mot de passe de {uid}
        </button>
        <button type="button" className="btn btn-secondary" onClick={() => navigate('/users')}>
          Retour
        </button>
      </div>
    </Layout>
  )
}

export default UserResetPwd
