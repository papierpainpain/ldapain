import React from 'react'
import './Gif2Pika.css'
import gifHome from './gif2Pika.gif'

function Gif2Pika() {
  return (
    <section className='secFigure'>
      <figure className='figureGif'>
        <img src={gifHome} alt='Gif D2Pika' className='image' />
      </figure>
    </section>
  )
}

export default Gif2Pika
