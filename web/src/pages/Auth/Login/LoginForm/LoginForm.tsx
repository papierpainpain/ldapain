import React, { useContext } from 'react'
import { useForm } from 'react-hook-form'
import './LoginForm.css'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faCircleUser } from '@fortawesome/free-solid-svg-icons'
import { Link, useNavigate, useLocation } from 'react-router-dom'
import AuthContext from '../../../../components/Auth/AuthContext'
import AuthService from '../../../../services/auth.service'

interface ITypeLoginForm {
  uid: string
  password: string
}

function LoginForm() {
  const {
    register,
    handleSubmit,
    formState: { errors },
  } = useForm<ITypeLoginForm>()
  const navigate = useNavigate()
  const location = useLocation()
  const { setAuth, setMessage } = useContext(AuthContext)

  const onSubmit = (data: ITypeLoginForm) => {
    AuthService.login(data.uid, data.password)
      .then((data) => {
        setAuth(data.token, data.user)

        setMessage({
          type: 'success',
          message: 'Vous êtes connecté !',
        })
        navigate(location.state?.from?.pathname || '/')
      })
      .catch((error) => {
        setMessage({
          type: 'danger',
          message: error?.response?.data?.error || 'Cette erreur est inconnue donc RIP !',
        })
      })
  }

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <FontAwesomeIcon icon={faCircleUser} className='profileIcon' />

      <div>
        <label className='sr-only' htmlFor='uid'>
          UID
        </label>
        <input
          type='text'
          // name='uid'
          id='uid'
          placeholder='UID'
          {...register('uid', {
            required: 'Veuillez entrer votre UID',
            minLength: {
              value: 3,
              message: 'Votre UID doit faire au moins 3 caractères',
            },
            // type: 'text',
          })}
        />
        {errors.uid && (
          <p className='error'>{errors.uid.message || 'Erreur inconnue, veuillez réessayer'}</p>
        )}
      </div>

      <div>
        <label className='sr-only' htmlFor='password'>
          Mot de passe
        </label>
        <input
          type='password'
          // name='password'
          id='password'
          placeholder='Mot de passe'
          {...register('password', {
            required: 'Veuillez entrer votre mot de passe',
            minLength: {
              value: 4,
              message: 'Votre mot de passe doit faire au moins 4 caractères',
            },
            // type: 'password',
          })}
        />
        {errors?.password && (
          <p className='error'>
            {errors.password.message || 'Erreur inconnue, veuillez réessayer'}
          </p>
        )}
      </div>

      <Link to='/reset-password' className='resetPwd'>
        J&apos;ai encore oublié mon mot de passe...
        <span>›</span>
      </Link>

      <button type='submit' className='button'>
        Connexion
      </button>
    </form>
  )
}

export default LoginForm
