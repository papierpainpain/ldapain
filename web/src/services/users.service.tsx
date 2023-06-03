import axios from 'axios'
import AuthService from './auth.service'
import ITypeUser from '../types/ITypeUser'

const BASE_URL = '/api/users/'

const headers = (token: string) => ({
  headers: {
    'Content-Type': 'application/json',
    Authorization: `Bearer ${token}`,
  },
})

const getAllUsers = async (token: string) => {
  const response = await axios.get(BASE_URL, headers(token))
  if (response.status === 403) {
    AuthService.logout()
  }
  return response.data
}

const getUserById = async (token: string, id: string) => {
  const response = await axios.get(BASE_URL + id, headers(token))
  return response.data
}

const createUser = async (token: string, user: ITypeUser) => {
  const response = await axios.post(BASE_URL, user, headers(token))
  return response.data
}

const updateUser = async (token: string, user: ITypeUser) => {
  const response = await axios.put(BASE_URL + user.uid, user, headers(token))
  return response.data
}

const deleteUser = async (token: string, uid: string) => {
  const response = await axios.delete(BASE_URL + uid, headers(token))
  return response.data
}

const resetPwdUser = async (token: string, uid: string) => {
  const response = await axios.put(`${BASE_URL}reset-pwd/${uid}`, null, headers(token))
  return response.data
}

const UsersService = {
  getAllUsers,
  getUserById,
  createUser,
  updateUser,
  deleteUser,
  resetPwdUser,
}

export default UsersService
