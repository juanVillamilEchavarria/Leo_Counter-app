import React from 'react'
import Button from './Button'
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
                {children}
        </div>
  )
}
