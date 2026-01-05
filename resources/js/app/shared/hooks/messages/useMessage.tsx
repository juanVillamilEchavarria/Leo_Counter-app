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
