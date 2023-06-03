import { useContext } from 'react'
import AuthContext from '../components/Auth/AuthContext'

const useRole = (role: string) => {
  const { token, roles: userRole } = useContext(AuthContext)
  return token && userRole && userRole.includes(role)
}

export default useRole
