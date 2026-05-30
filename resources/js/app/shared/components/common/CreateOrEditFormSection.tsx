/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import React from 'react'
import Button from './Button'
import TransitionMotion from '../transitions/TransitionMotion'
import { Link } from '@inertiajs/react'

export default function CreateOrEditFormSection({
    buttonHref='',
    children,
    className = ''
}:{
    buttonHref ?: string,
    children : React.ReactNode
    className ?: string
}) {
  return (
     <div className={`w-full px-4 sm:px-6 lg:w-1/2 lg:px-0 mt-10 mx-auto ${className ?? ''}`}>
         <Button
            as={Link} 
            variant="primaryPagination" 
            className="rounded-lg! text-xl" 
            href={buttonHref}
            >
          <i className="fa-solid fa-arrow-left"></i>
         </Button>
         <TransitionMotion   active
            initial={{ y: -12, opacity: 0 }}
            animate={{ y: 0, opacity: 1 }}
            transition={{
              duration: 0.35,
              ease: [0.22, 1, 0.36, 1], 
            }} >        
                  {children}
          </TransitionMotion>
        </div>
  )
}
