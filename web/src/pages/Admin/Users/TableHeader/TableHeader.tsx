import React from 'react'
import { Checkbox, TableCell, TableHead, TableRow } from '@mui/material'

function TableHeader() {
  return (
    <TableHead>
      <TableRow>
        <TableCell padding='checkbox'>
          <Checkbox
            color='primary'
            inputProps={{
              'aria-label': 'select all desserts',
            }}
          />
        </TableCell>
        <TableCell>UID</TableCell>
        <TableCell>Prénom</TableCell>
        <TableCell>Nom</TableCell>
        <TableCell>Email</TableCell>
      </TableRow>
    </TableHead>
  )
}

export default TableHeader
