import { useEffect } from "react"
import { useMessageRedirect } from "../../hooks"
import { toastHelper } from "../../helpers"

export default function FlashToastListener() {
    const {flash}= useMessageRedirect()
  
    const {success, error}= toastHelper
      useEffect(() => {
    if (flash?.success) success(flash.success)
    if (flash?.error) error(flash.error)
  }, [flash])
  return null
}
