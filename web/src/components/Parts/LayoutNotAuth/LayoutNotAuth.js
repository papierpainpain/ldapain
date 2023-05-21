import React, { useContext } from 'react'
import PropTypes from 'prop-types'
import Gif2Pika from '../Gif2Pika/Gif2Pika'
import LogoHeader from './LogoHeader/LogoHeader'
import './LayoutNotAuth.css'
import AuthContext from '../../Auth/AuthContext'
import Message from '../Message/Message'

function LayoutNotAuth({ title, children }) {
  LayoutNotAuth.propTypes = {
    title: PropTypes.string.isRequired,
    children: PropTypes.node.isRequired
  }

  const { message, setMessage } = useContext(AuthContext)

  return (
    <div className="notAuthContainer">
      {message?.message && (
        <Message type={message.type} message={message.message} setMessage={setMessage} />
      )}

      <LogoHeader />

      <main>
        <div className="container">
          <section className="secForm">
            <div className="box">
              <h1>{title}</h1>

              {children}
            </div>
          </section>

          <Gif2Pika />
        </div>
      </main>
    </div>
  )
}

export default LayoutNotAuth
