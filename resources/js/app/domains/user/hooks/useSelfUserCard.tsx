import { usePortalRoot } from "@/app/shared/hooks";
import {  useEffect, useState } from "react"
import { useRef } from "react";
import useOpen from "@/app/shared/hooks/open/useOpen";
import { type useSelfUserCardProps } from "../types/user.types";

export default function useSelfUserCard({
    isOpen = false,
}:useSelfUserCardProps) {
        const buttonRef = useRef<HTMLButtonElement>(null)
        const [cardStyle, setCardStyle] = useState({top: 0, left: 0})
        const {isOpen : isOpenCard, setIsOpen : setIsOpenCard} = useOpen(false)
    
        // este useeffect es para detectar si se cerro el sidebar, y si es asi se cierra el card de opciones
        useEffect(() => {
            if(buttonRef.current && isOpen){
                const rect = buttonRef.current.getBoundingClientRect();
                setCardStyle({
                    top: rect.bottom + window.scrollY + 8, // 8px de separación
                    left: rect.left + window.scrollX,
                });
            }
           if (!isOpen) setIsOpenCard(false)
        }, [isOpen])
    
        // se crea el portal para renderizar el card de opciones
        const portal = usePortalRoot('portal-root')
  return {
      buttonRef,
      cardStyle,
      isOpenCard,
      setIsOpenCard,
      portal
  }
}
