import React, { useContext } from 'react'
import PropTypes from 'prop-types'
import { Navigate, useLocation } from 'react-router-dom'
import AuthContext from './AuthContext'

function AuthRequire({ requireRoles = [], children }) {
  AuthRequire.propTypes = {
    requireRoles: PropTypes.arrayOf(PropTypes.string).isRequired,
    children: PropTypes.node.isRequired
  }

  const { auth, role } = useContext(AuthContext)
  const location = useLocation()

  const hasRoles = () => {
    if (requireRoles.length === 0) {
      return true
    }
    return requireRoles.some((r) => role.includes(r))
  }

  if (auth) {
    if (hasRoles()) {
      return children
    }
    return <Navigate to="/" />
  }
  return <Navigate to="/login" replace state={{ from: location }} />
}

export default AuthRequire
