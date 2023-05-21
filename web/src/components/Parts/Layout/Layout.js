import React, { useContext } from 'react'
import PropTypes from 'prop-types'
import './Layout.css'
import Header from '../Header/Header'
import AuthContext from '../../Auth/AuthContext'
import Message from '../Message/Message'

function Layout({ title, children }) {
  Layout.propTypes = {
    title: PropTypes.string.isRequired,
    children: PropTypes.node.isRequired
  }

  const { message, setMessage } = useContext(AuthContext)

  return (
    <div className="mainContainer">
      {message?.message && (
        <Message type={message.type} message={message.message} setMessage={setMessage} />
      )}

      <Header />

      <main>
        <h1>{title}</h1>

        <section>
          <div className="block">{children}</div>
        </section>
      </main>
    </div>
  )
}

export default Layout
