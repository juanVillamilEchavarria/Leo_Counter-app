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
