import React, { useContext } from 'react'
import { Link } from 'react-router-dom'
import HeaderLogo from './HeaderLogo/HeaderLogo'
import HeaderNav from './HeaderNav/HeaderNav'
import './Header.css'
import AuthContext from '../../Auth/AuthContext'
import gif from './pika.gif'

function Header() {
  const { isMobile } = useContext(AuthContext)

  return (
    <header className={isMobile ? 'headerMobile' : 'headerDesktop'}>
      <HeaderLogo />

      {!isMobile ? <HeaderNav /> : null}

      {!isMobile ? (
        <div className="headerGif">
          <img src={gif} alt="gif" />
        </div>
      ) : null}

      <Link to="/logout" className="buttonLink" role="button">
        Déconnexion
      </Link>
    </header>
  )
}

export default Header
