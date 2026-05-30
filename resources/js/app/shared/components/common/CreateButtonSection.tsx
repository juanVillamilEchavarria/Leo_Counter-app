/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import React from 'react'

export default function CreateButtonSection({
    children,
}:{
    children : React.ReactNode
}) {
  return (
    <div className="w-full flex justify-center lg:justify-start my-2">
              <div className="border-b-2 border-green-800 flex flex-col" >
                {children}
            </div>

        </div>
  )
}
