import React, { useContext } from 'react'
import { Navigate, useLocation } from 'react-router-dom'
import AuthContext from './AuthContext'

interface AuthRequireProps {
  requireRoles: string[] | null
  children: JSX.Element
}

function AuthRequire(props: AuthRequireProps) {
  const { token, roles, user } = useContext(AuthContext)
  const location = useLocation()

  /**
   * Retourne si l'utilisateur a les droits requis pour accéder à la page
   *
   * @returns boolean
   */
  const hasRoles = () => {
    if (!props.requireRoles || (props.requireRoles && props.requireRoles.length === 0)) {
      return true
    } else {
      return roles ? props.requireRoles.some((r) => roles.includes(r)) : false
    }
  }

  if (token && user) {
    if (hasRoles()) {
      return props.children
    }
    return <Navigate to='/' />
  }
  return <Navigate to='/login' replace state={{ from: location }} />
}

export default AuthRequire
