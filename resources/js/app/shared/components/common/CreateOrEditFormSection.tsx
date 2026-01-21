import React from 'react'
import Button from './Button'
import TransitionMotion from '../transitions/TransitionMotion'
import { Link } from '@inertiajs/react'

export default function CreateOrEditFormSection({
    buttonHref='',
    children
}:{
    buttonHref ?: string,
    children : React.ReactNode
}) {
  return (
     <div className="w-1/2 mt-10 mx-auto">
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
