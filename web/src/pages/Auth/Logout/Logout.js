import { useContext, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import AuthContext from '../../../components/Auth/AuthContext'

const Logout = () => {
  const { setToken } = useContext(AuthContext)
  const navigate = useNavigate()

  useEffect(() => {
    setToken(null)
    navigate('/login')
  }, [setToken, navigate])
}

export default Logout
