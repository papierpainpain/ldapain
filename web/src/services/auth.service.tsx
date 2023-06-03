import axios from 'axios'

const BASE_URL = '/api/'

const login = async (uid: string, password: string) => {
  const response = await axios({
    method: 'post',
    url: `${BASE_URL}token`,
    data: {
      uid,
      password,
    },
    headers: { 'Content-Type': 'application/json' },
  })

  return response.data
}

const updateProfile = async (token: string, firstname: string, lastname: string) => {
  const response = await axios({
    method: 'put',
    url: `${BASE_URL}profile`,
    data: {
      cn: lastname,
      sn: firstname,
    },
    headers: {
      'Content-Type': 'application/json',
      Authorization: `Bearer ${token}`,
    },
  })

  return response.data
}

const logout = () => {
  localStorage.removeItem('token')
}

const resetPassword = async (uid: string) => {
  const response = await axios({
    method: 'put',
    url: `${BASE_URL}profile/password/reset`,
    data: {
      uid,
    },
    headers: { 'Content-Type': 'application/json' },
  })

  return response.data
}

const updatePassword = async (token: string, oldPassword: string, newPassword: string) => {
  const response = await axios({
    method: 'put',
    url: `${BASE_URL}profile/password`,
    data: {
      oldPassword,
      newPassword,
    },
    headers: {
      'Content-Type': 'application/json',
      Authorization: `Bearer ${token}`,
    },
  })

  return response.data
}

const AuthService = {
  login,
  updateProfile,
  logout,
  resetPassword,
  updatePassword,
}

export default AuthService
