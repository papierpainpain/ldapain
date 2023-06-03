import React, { useContext } from 'react'
import { useForm } from 'react-hook-form'
import { useLocation, useNavigate } from 'react-router-dom'
import AuthContext from '../../../../components/Auth/AuthContext'
import AuthService from '../../../../services/auth.service'
import ProfileHeader from '../../../../components/Parts/ProfileHeader/ProfileHeader'
import './ChangePasswordForm.css'
import ITypeUser from '../../../../types/ITypeUser'

interface ITypeChangePasswordForm {
  oldPassword: string
  newPassword: string
  confPassword: string
}

function ChangePasswordForm() {
  const { token, setAuth, setMessage, user } = useContext(AuthContext)
  const navigate = useNavigate()
  const location = useLocation()
  const {
    register,
    handleSubmit,
    formState: { errors },
    clearErrors,
    watch,
  } = useForm({
    defaultValues: {
      oldPassword: '',
      newPassword: '',
      confPassword: '',
    },
  })
  const oldPassword = watch('oldPassword')
  const newPassword = watch('newPassword')

  const pwdIsValid = (pwd: string) => {
    if (pwd === oldPassword) {
      return 'Le nouveau mot de passe ne peut pas être identique à l\'ancien !'
    }
    if (pwd.length < 8) {
      return 'Le mot de passe doit contenir au moins 8 caractères !'
    }
    if (pwd.search(/[0-9]/) === -1) {
      return 'Le mot de passe doit contenir au moins un chiffre !'
    }
    if (pwd.search(/[a-z]/) === -1) {
      return 'Le mot de passe doit contenir au moins une minuscule !'
    }
    if (pwd.search(/[A-Z]/) === -1) {
      return 'Le mot de passe doit contenir au moins une majuscule !'
    }
    if (pwd.search(/[^a-zA-Z0-9]/) === -1) {
      return 'Le mot de passe doit contenir au moins un caractère spécial !'
    }
    return true
  }

  const confPwdIsValid = (pwd: string, confPwd: string) => pwd === confPwd

  const onSubmit = (data: ITypeChangePasswordForm) => {
    AuthService.updatePassword(token as string, data.oldPassword, data.newPassword)
      .then((data) => {
        setAuth(data.token, data.user)
        setMessage({
          type: 'success',
          message: 'Mot de passe mis à jour avec succès',
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
    <>
      <ProfileHeader user={user as ITypeUser} />

      <form onSubmit={handleSubmit(onSubmit)} className='changePwdForm'>
        <div className='row'>
          <div className='item'>
            <label htmlFor='oldPassword' className='itemTitle'>
              Ancien mot de passe
            </label>
            <input
              type='password'
              id='oldPassword'
              // name='oldPassword'
              placeholder='Ancien mot de passe'
              className='itemContent'
              {...register('oldPassword', {
                required: 'Veuillez entrer votre ancien mot de passe',
                minLength: {
                  value: 4,
                  message: 'Votre mot de passe doit faire au moins 4 caractères',
                },
                // type: 'password',
              })}
            />
            {errors?.oldPassword && (
              <p className='error'>
                {errors.oldPassword.message || 'Erreur inconnue, veuillez réessayer'}
              </p>
            )}
          </div>
          <div className='item'>
            <label htmlFor='newPassword' className='itemTitle'>
              Nouveau mot de passe
            </label>
            <input
              type='password'
              id='newPassword'
              // name='newPassword'
              placeholder='Nouveau mot de passe'
              className='itemContent'
              {...register('newPassword', {
                required: 'Veuillez entrer votre nouveau mot de passe',
                validate: (value: string) => pwdIsValid(value),
                // type: 'password',
              })}
            />
            {errors?.newPassword && (
              <p className='error'>
                {errors.newPassword.message || 'Erreur inconnue, veuillez réessayer'}
              </p>
            )}
          </div>
        </div>

        <div className='row'>
          <div className='item col-6'>
            <label htmlFor='confPassword' className='itemTitle'>
              Confirmation mot de passe
            </label>
            <input
              type='password'
              id='confPassword'
              // name='confPassword'
              placeholder='Confirmation mot de passe'
              className='itemContent'
              {...register('confPassword', {
                required: 'Veuillez confirmer le mot de passe',
                validate: (value: string) =>
                  confPwdIsValid(value, newPassword) || 'Vos mots de passe ne correspondent pas',
                // type: 'password',
              })}
            />
            {errors?.confPassword && (
              <p className='error'>
                {errors.confPassword.message || 'Erreur inconnue, veuillez réessayer'}
              </p>
            )}
          </div>
        </div>

        <button type='submit' className='submit' onClick={() => clearErrors()}>
          Enregistrer
        </button>
      </form>
    </>
  )
}

export default ChangePasswordForm
