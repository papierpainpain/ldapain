import { useContext, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import AuthContext from '../../../components/Auth/AuthContext'

const Logout = () => {
  const { setAuth } = useContext(AuthContext)
  const navigate = useNavigate()

  useEffect(() => {
    setAuth(null, null)
    navigate('/login')
  }, [setAuth, navigate])

  return <></>
}

export default Logout
