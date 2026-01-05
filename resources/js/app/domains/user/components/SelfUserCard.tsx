import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion"
import useOpen from "@/app/shared/hooks/open/useOpen"
import SelfOptionsCard from "./SelfOptionsCard"
import {  useEffect } from "react"
import { type SelfUserCardsProps } from "../types/user.types"
export default function SelfUserCard({
    isOpen = false,
    user
}:SelfUserCardsProps) {
    // si no hay name o role no se renderiza
    if(!user.name || !user.role) return null
    const {isOpen : isOpenCard, setIsOpen : setIsOpenCard} = useOpen(false)
    // este useeffect es para detectar si se cerro el sidebar, y si es asi se cierra el card de opciones
    useEffect(() => {
       if (!isOpen) setIsOpenCard(false)
    }, [isOpen])

  return (
    <div className="flex flex-row items-center justify-between w-full bg-zinc-950/40 p-2 rounded-2xl relative">
        <div 
            className="
            flex
            flex-row 
            items-center
            gap-3
            "
        >
           {/* muestra la imagen del usuario */}
            <div 
                className="
                bg-white/80
                p-2 
                rounded-full
                "
            >

                <i className="fa-solid fa-user fa-lg"></i>
            </div>

            {/* muestra el nombre y el rol del usuario */}
                <TransitionMotion
                 active={isOpen}
                 initial={
                    {
                    opacity:0, x: -70
                    }
                 }
                >
                    <div className="flex flex-col">
                        <p className="text-sm text-white whitespace-nowrap">{user.name}</p>
                        <p className="text-xs text-white whitespace-nowrap">{user.role}</p>
                    </div>
                </TransitionMotion>
            
        </div>
        <div> {/* este div no tiene estilos porque solo envuelve todo el contenido para que eñ justify-between del elemento padre no mueva al boton de abrir el card */}

            
              {/* muestra el boton para abrir el card de opciones */}
            <TransitionMotion 
            active={isOpen} 
            initial={
                    {
                    opacity:0, x: -70
                    }
                }>
                    <div className="border-l-2  border-white/80">
                        <button
                        className="cursor-pointer ml-2 hover:bg-white/20 rounded-xl text-white py-1 "
                        onClick={() => setIsOpenCard(prev => !prev)}
                        >
                            <i className={`
                                fa-solid
                                fa-chevron-right
                                transition-all
                                duration-500
                                ${isOpenCard ? 'fa-rotate-180' : ''} 
                                 mx-3
                                `}
                            >

                            </i>
                        </button>
                    </div>
                    
                
            </TransitionMotion>
            {/* muestra el card de opciones */}
            <TransitionMotion 
                    active={isOpenCard} 
                    initial={
                            {
                            opacity: 0,
                            scaleY:0,
                            scaleX:0}
                        } 
                    animate={
                            {
                            opacity: 1,
                            scaleY:1, 
                            scaleX:1,
                            y: -180,
                            x: 40}
                        } 
                    exit={
                            {
                            opacity: 0,
                            scaleY:0,
                            scaleX:0,
                            y: 0}
                        } 
                    transition={
                        {
                        duration: 0.25}
                    }
                    >
                        {/* este es el card de opciones */}
                        <SelfOptionsCard />
                </TransitionMotion>
        

        </div>
        
    
            
    </div>
  )
}
