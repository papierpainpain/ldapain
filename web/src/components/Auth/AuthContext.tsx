import { createContext } from 'react'
import ITypeMessage from '../../types/ITypeMessage'
import ITypeUser from '../../types/ITypeUser'

interface AuthContextProps {
  setAuth: (newToken: string | null, newUser: ITypeUser | null) => void
  token: string | null
  roles: string[] | null
  user: ITypeUser | null
  message: ITypeMessage
  setMessage: (message: ITypeMessage) => void
  isMobile: boolean
}

const AuthContext = createContext<AuthContextProps>({} as AuthContextProps)

export default AuthContext
