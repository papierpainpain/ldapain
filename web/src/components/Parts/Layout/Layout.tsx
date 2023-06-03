import React, { useContext } from 'react'
import './Layout.css'
import Header from '../Header/Header'
import AuthContext from '../../Auth/AuthContext'
import Message from '../Message/Message'

interface LayoutProps {
  title: string
  children: JSX.Element | JSX.Element[]
}

function Layout(props: LayoutProps) {
  const { message, setMessage } = useContext(AuthContext)

  return (
    <div className='mainContainer'>
      {message?.message && (
        <Message type={message.type} message={message.message} setMessage={setMessage} />
      )}

      <Header />

      <main>
        <h1>{props.title}</h1>

        <section>
          <div className='block'>{props.children}</div>
        </section>
      </main>
    </div>
  )
}

export default Layout
