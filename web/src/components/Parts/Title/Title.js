import React from 'react'
import { Link } from 'react-router-dom'
import './Title.css'

function Title() {
  return (
    <Link to="/" className="title">
      <span id="navbrand-green">LDAP</span>
      <span id="navbrand-white">ain</span>
      <span id="navbrand-orange">/GPerduMonMdp</span>
    </Link>
  )
}

export default Title
