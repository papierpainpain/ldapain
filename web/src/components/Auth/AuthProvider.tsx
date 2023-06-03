import React, { useEffect, useState } from 'react'
import AuthContext from './AuthContext'
import useAuth from '../../hooks/useAuth'
import ITypeMessage from '../../types/ITypeMessage'

interface AuthProviderProps {
  children: JSX.Element | JSX.Element[] | string | string[]
}

function AuthProvider({ children }: AuthProviderProps) {
  const { setAuth, token, roles, user } = useAuth()
  const [message, setMessage] = useState({} as ITypeMessage)
  const [isMobile, setIsMobile] = useState(window.innerWidth < 1200)

  useEffect(() => {
    window.addEventListener(
      'resize',
      () => {
        setIsMobile(window.innerWidth < 950)
      },
      isMobile,
    )
  }, [isMobile, setIsMobile])

  return (
    <AuthContext.Provider
      value={{
        setAuth,
        token,
        roles,
        user,
        message,
        setMessage,
        isMobile,
      }}
    >
      {children}
    </AuthContext.Provider>
  )
}

export default AuthProvider
