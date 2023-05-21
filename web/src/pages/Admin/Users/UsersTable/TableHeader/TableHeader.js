import React from 'react'
import './TableHeader.css'

function TableHeader() {
  return (
    <thead>
      <tr>
        <th className="tabHeader" scope="col">
          #
        </th>
        <th className="tabHeader" scope="col">
          Utilisateur
        </th>
        <th className="tabHeader" scope="col">
          Email
        </th>
        <th className="tabHeader" scope="col">
          Actions
        </th>
      </tr>
    </thead>
  )
}

export default TableHeader
