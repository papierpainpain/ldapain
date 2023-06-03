import React, { useContext } from 'react'
import './Profile.css'
import { useForm } from 'react-hook-form'
import { Link } from 'react-router-dom'
import AuthContext from '../../../components/Auth/AuthContext'
import AuthService from '../../../services/auth.service'
import ProfileHeader from '../../../components/Parts/ProfileHeader/ProfileHeader'
import ITypeUser from '../../../types/ITypeUser'

interface ITypeProfile {
  firstname: string
  lastname: string
  email: string
}

function Profile() {
  const { token, setAuth, setMessage, user } = useContext(AuthContext)
  const {
    register,
    handleSubmit,
    formState: { errors },
    clearErrors,
  } = useForm({
    defaultValues: {
      firstname: user?.sn || '',
      lastname: user?.cn || '',
      email: user?.mail || '',
    },
  })

  const onSubmit = (data: ITypeProfile) => {
    AuthService.updateProfile(token as string, data.firstname, data.lastname)
      .then((data) => {
        setAuth(data.token, data.user)

        setMessage({
          type: 'success',
          message: 'Profil mis à jour !',
        })
      })
      .catch((error) => {
        setMessage({
          type: 'error',
          message: error?.response?.data?.error || 'Cette erreur est inconnue donc RIP !',
        })
      })
  }

  return (
    <>
      <ProfileHeader user={user as ITypeUser} />

      <form onSubmit={handleSubmit(onSubmit)} className='profileForm'>
        <div className='row'>
          <div className='item'>
            <label htmlFor='firstname' className='itemTitle'>
              Prénom
            </label>
            <input
              type='text'
              id='firstname'
              // name='firstname'
              placeholder='Prénom'
              className='itemContent'
              {...register('firstname', {
                required: 'Veuillez entrer votre prénom',
                minLength: {
                  value: 2,
                  message: 'Votre prénom doit faire au moins 2 caractères',
                },
                // type: 'text',
              })}
            />
            {errors?.firstname && (
              <p className='error'>
                {errors.firstname.message || 'Erreur inconnue, veuillez réessayer'}
              </p>
            )}
          </div>
          <div className='item'>
            <label htmlFor='lastname' className='itemTitle'>
              Nom
            </label>
            <input
              type='text'
              id='lastname'
              // name='lastname'
              placeholder='Nom'
              className='itemContent'
              {...register('lastname', {
                required: 'Veuillez entrer votre nom',
                minLength: {
                  value: 2,
                  message: 'Votre nom doit faire au moins 2 caractères',
                },
                // type: 'text',
              })}
            />
            {errors?.lastname && (
              <p className='error'>
                {errors.lastname.message || 'Erreur inconnue, veuillez réessayer'}
              </p>
            )}
          </div>
        </div>

        <div className='row'>
          <div className='item'>
            <label htmlFor='email' className='itemTitle'>
              Email
            </label>
            <input
              type='email'
              // name='email'
              id='email'
              className='itemContent'
              {...register('email', {
                required: 'Veuillez entrer votre email',
                // email: 'Votre email n\'est pas valide',
                // type: 'email',
                disabled: true,
              })}
            />
          </div>
          <div className='item'>
            <p className='itemTitle'>Mot de passe</p>
            <Link to='/change-password' className='itemContent button'>
              Changer le mot de passe ›
            </Link>
          </div>
        </div>

        <button type='submit' className='submit' onClick={() => clearErrors()}>
          Enregistrer
        </button>
      </form>
    </>
  )
}

export default Profile
