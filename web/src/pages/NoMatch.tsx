import React from 'react'
import Layout from '../components/Parts/Layout/Layout'

function NoMatch() {
  return (
    <Layout title="AH AH AH AH ! Tu t'es trompé de page ! (C'est pas la bonne)">
      <p>
        Ca s&apos;appelle une erreur 404, mais c&apos;est pas grave (en fait SI), tu peux retourner
        à la page d&apos;accueil.
      </p>
    </Layout>
  )
}

export default NoMatch
