import { usePage } from "@inertiajs/react"
import { type FlashMessages, type InertiaProps } from "../../types";

/**
 *  este hook se encarga de capturar los mensajes de inertia, ya sea por flash o por props  
 * @returns un objeto con los mensajes de flash y las props de inertia, para ser usados en cualquier componente que lo necesite, como el sidebar para mostrar el nombre del usuario logueado 
 */
export default function useMessageRedirect() {
    const {  flash, props}: { flash: FlashMessages, props: InertiaProps } = usePage();
  
  return {
    flash,
    props
  }
}
