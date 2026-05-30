/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useState } from "react";
/**
 * hook que maneja el estado de verificación de un suscriptor, con un id de suscriptor en proceso de verificación y un booleano que indica si se ha verificado o no.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @returns 
 */
export default function useSuscriptorVerify(){
     const [verifyingId, setVerifyingId] = useState<string | null>(null)
  const [verified, setVerified] = useState(false)
  return {
    verifyingId,
    setVerifyingId,
    verified,
    setVerified
  }

}
