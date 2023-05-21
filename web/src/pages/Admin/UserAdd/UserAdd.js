import React from 'react'
import Layout from '../../../components/Parts/Layout/Layout'
import UserAddForm from './UserAddForm/UserAddForm'

function UserAdd() {
  return (
    <Layout title="Ajout d'un utilisateur">
      <UserAddForm />
    </Layout>
  )
}

export default UserAdd
