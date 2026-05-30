/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useFormNormal } from "@/app/shared/hooks"
export default function useLogout() {
  const {form, handleSubmit} = useFormNormal({
    action: '/logout',
    data: {}
  })
  return {
    form,
    handleSubmit
  }
}
