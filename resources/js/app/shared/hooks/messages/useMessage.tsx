/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useState, useEffect } from "react"

export default function useMessage({
    defaultMessage,
    timeout=3000
}:{
    defaultMessage: string | undefined
    timeout?: number
}) { 
    const [message, setMessage] = useState(defaultMessage)
    useEffect(() => {
        setMessage(defaultMessage)
    }, [defaultMessage])


    useEffect(() => {
        if(message === '') return
        const timer = setTimeout(() => {
            setMessage('')
        }, timeout)
        return () => clearTimeout(timer)
    }, [message, timeout])
    
  return {
    message,
    setMessage
  }
}
