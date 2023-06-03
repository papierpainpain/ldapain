import React from 'react'
import ResetPasswordForm from './ResetPasswordForm/ResetPasswordForm'
import LayoutNotAuth from '../../../components/Parts/LayoutNotAuth/LayoutNotAuth'

function ResetPassword() {
  return (
    <LayoutNotAuth title='GPerduMonMdp'>
      <ResetPasswordForm />
    </LayoutNotAuth>
  )
}

export default ResetPassword
