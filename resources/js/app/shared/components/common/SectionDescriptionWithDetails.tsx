/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
import React from 'react'
import Title from './Title'
import { useOpen } from '../../hooks'
import TransitionMotion from '../transitions/TransitionMotion'
interface DescriptionItem{
    title: string,
    description: string | React.ReactNode,
    icon: string
}
export default function SectionDescriptionWithDetails({
    principalTitle,
    className,
    paragraph,
 items
}:{
    principalTitle: string,
    className ?: string,
    paragraph: string | React.ReactNode,
    items: DescriptionItem[]
}) {
    const {isOpen, setIsOpen}=useOpen(true);
  return (
    <div className={`flex flex-col justify-start items-start gap-2 my-5 ${className}`}> 
           <Title title={principalTitle} size="3xl" className={` font-principal `} />
           <button
            onClick={()=>setIsOpen(!isOpen)}
            className='flex items-center text-foreground text-sm font-principal mt-2 hover:text-blue-500 transition-colors duration-300 gap-1 cursor-pointer'
            >
             <p>{paragraph}</p>
                <i className={ ` fa-solid ${isOpen ? 'fa-chevron-up' : 'fa-chevron-down'} text-xs`}></i>
           </button>
          <TransitionMotion className="flex md:flex-row flex-col md:items-stretch justify-center sm:items-center  w-[90%] mx-auto gap-9 my-10  " active={isOpen} initial={{opacity:0, y:-40}} exit={{opacity:0, y: -40}}>
            {items.map((item, index)=>(
                <div key={index} className={`flex flex-col justify-start items-center gap-2 p-4 rounded-lg border-2 border-muted-foreground/10 max-w-md `}>
                    <i className={`${item.icon} text-5xl text-primary my-3`}></i>
                    <h3 className='text-lg font-semibold text-center text-foreground'>{item.title}</h3>
                    <p className='text-sm text-center text-muted-foreground'>{item.description}</p>
                </div>
            ))}
          </TransitionMotion>
      </div>
  )
}
