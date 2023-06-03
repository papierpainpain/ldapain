import { useState } from 'react'
import ITypeUser from '../types/ITypeUser'

const useAuth = () => {
  const getDataFromStorage = (name: string) => {
    const storageData = localStorage.getItem(name)

    if (storageData?.length && storageData !== 'undefined') {
      return storageData
    }
    return null
  }

  const cleanStorage = () => {
    localStorage.removeItem('token')
    localStorage.removeItem('roles')
    localStorage.removeItem('user')
  }

  const getToken = () => {
    const tokenFS = getDataFromStorage('token')

    if (tokenFS) {
      return tokenFS
    }

    cleanStorage()
    return null
  }

  const getRoles = () => {
    const rolesFS = getDataFromStorage('roles')

    if (rolesFS) {
      return rolesFS.split(',')
    }

    return null
  }

  const getUser = () => {
    const user = getDataFromStorage('user')

    if (user) {
      return JSON.parse(user) as ITypeUser
    }

    cleanStorage()
    return null
  }

  const [token, setToken] = useState(getToken())
  const [roles, setRoles] = useState(getRoles())
  const [user, setUser] = useState(getUser())

  const saveConnection = (newToken: string | null, newUser: ITypeUser | null) => {
    if (!newToken || !newUser) {
      cleanStorage()
      setToken(null)
      setRoles(null)
      setUser(null)
    } else {
      if (newToken) {
        localStorage.setItem('token', newToken)
        setToken(newToken)
      }

      if (newUser) {
        localStorage.setItem('user', JSON.stringify(newUser))
        setUser(newUser)

        if (newUser.memberOf) {
          localStorage.setItem('roles', newUser.memberOf.join(','))
          setRoles(newUser.memberOf)
        }
      }
    }
  }

  return { setAuth: saveConnection, token, roles, user }
}

export default useAuth
