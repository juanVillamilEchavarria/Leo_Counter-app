import { usePage } from "@inertiajs/react"
import { type FlashMessages, type InertiaProps } from "../../types";

// este hook se encarga de capturar los mensajes de inertia, ya sea por flash o por props  
export default function useMessageRedirect() {
    const {  flash, props}: { flash: FlashMessages, props: InertiaProps } = usePage();
  
  return {
    flash,
    props
  }
}
