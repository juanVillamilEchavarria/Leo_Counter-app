import { useForm } from '@inertiajs/react'
import { ConfiguracionActions, type SoftDeletedDomainsNames } from '../types/configuracion.types'
/**
 * Hook que ejecuta las acciones especiales de la seccion de configuracion
 * @returns {Object} Objeto con las acciones y el formulario
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
export default function useConfiguracionActions<TPayload extends Record<string, any>>() {
  const form = useForm<TPayload>({} as TPayload)

  const restore = (domain : SoftDeletedDomainsNames, id?: number) => {
    if(!id)return
      form.put(ConfiguracionActions.restore( domain, id))
  }
  const hardDelete = (domain : SoftDeletedDomainsNames, id?: number) => {
    if(!id)return
      form.delete(ConfiguracionActions.hardDelete(domain, id))
  }
  return {
    form,
    restore,
    hardDelete
  }
}
