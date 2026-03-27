import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion"
import SelfOptionsCard from "./SelfOptionsCard"
import { createPortal } from 'react-dom';
import useSelfUserCard from "../hooks/useSelfUserCard";
import { type SelfUserCardProps } from "../types/user.types"
export default function SelfUserCard({
    isOpen = false,
    user
}:SelfUserCardProps) {
    // si no hay name o role no se renderiza
    if(!user.name || !user.role) return null
    const {buttonRef, cardStyle, isOpenCard, setIsOpenCard, portal} = useSelfUserCard({isOpen})
    if(!portal) return null
  return (
    <div className="flex flex-row items-center justify-between mt-3 w-full p-2 rounded-2xl">
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
                bg-background/80
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
                        <p className="text-sm  whitespace-nowrap">{user.name}</p>
                        <p className="text-xs  whitespace-nowrap">{user.role}</p>
                    </div>
                </TransitionMotion>
            
        </div>
        <div> {/* este div no tiene estilos porque solo envuelve todo el contenido para que el justify-between del elemento padre no mueva al boton de abrir el card */}

            
              {/* muestra el boton para abrir el card de opciones */}
            <TransitionMotion 
            active={isOpen} 
            initial={
                    {
                    opacity:0, x: -70
                    }
                }>
                    <div className="border-l-2  border-gray-700/80">
                        <button
                        className="cursor-pointer ml-2 hover:bg-background/20 rounded-xlpy-1 "
                        onClick={() => setIsOpenCard(prev => !prev)}
                        ref={buttonRef}
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
            {typeof document !== 'undefined' && createPortal(
                <TransitionMotion 
                    active={isOpenCard} 
                    initial={
                            {
                            opacity: 0,
                            scaleY:0,
                            scaleX:0,
                            y: -150,
                            x: 100}
                        } 
                    animate={
                            {
                            opacity: 1,
                            scaleY:1, 
                            scaleX:1,
                            y: -250,
                            x: 250}
                        } 
                    exit={
                            {
                            opacity: 0,
                            scaleY:0,
                            scaleX:0,
                            y: -150,
                            x: 100}
                        } 
                    transition={
                        {
                        duration: 0.25}
                    }
                    layout={false}
                    style={{
                        position: "absolute",
                        top: cardStyle.top,
                        left: cardStyle.left,
                        zIndex: 1000,
                    }}
                    className="fixed -bottom-35 left-10 z-100 pointer-events-auto"
                    >
                        {/* este es el card de opciones */}
                        <SelfOptionsCard />
                </TransitionMotion>,
                portal
                
            )}
            
        

        </div>
        
    
            
    </div>
  )
}
