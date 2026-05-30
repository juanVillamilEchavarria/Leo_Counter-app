/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
