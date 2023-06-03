import React, { useEffect } from 'react'
import './Message.css'
import { faCircleXmark } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import ITypeMessage from '../../../types/ITypeMessage'

interface MessageProps {
  type: string
  message: string | null
  setMessage: (message: ITypeMessage) => void
}

function Message(props: MessageProps) {
  useEffect(() => {
    setTimeout(() => props.setMessage({} as ITypeMessage), 5000)
  }, [props.setMessage])

  const handleClose = () => {
    props.setMessage({} as ITypeMessage)
  }

  return (
    <div className={`alert alert-${props.type}`} role='alert'>
      <p>{props.message}</p>
      <FontAwesomeIcon icon={faCircleXmark} className='icon' onClick={handleClose} />
    </div>
  )
}

export default Message
