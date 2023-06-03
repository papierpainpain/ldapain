import React, { useContext } from 'react'
import Gif2Pika from '../Gif2Pika/Gif2Pika'
import LogoHeader from './LogoHeader/LogoHeader'
import './LayoutNotAuth.css'
import AuthContext from '../../Auth/AuthContext'
import Message from '../Message/Message'

interface LayoutNotAuthProps {
  title: string
  children: JSX.Element
}

function LayoutNotAuth(props: LayoutNotAuthProps) {
  const { message, setMessage } = useContext(AuthContext)

  return (
    <div className='notAuthContainer'>
      {message?.message && (
        <Message type={message.type} message={message.message} setMessage={setMessage} />
      )}

      <LogoHeader />

      <main>
        <div className='container'>
          <section className='secForm'>
            <div className='box'>
              <h1>{props.title}</h1>

              {props.children}
            </div>
          </section>

          <Gif2Pika />
        </div>
      </main>
    </div>
  )
}

export default LayoutNotAuth
