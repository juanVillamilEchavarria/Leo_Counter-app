/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { router } from '@inertiajs/react'
import { type useModelToggleProps } from '@/app/shared/types/components'
export default function useModelToggle({
    route,
    payload = {},
    options
}:useModelToggleProps) {
    const toggle = () => {
    router.patch(route, payload, {
      preserveScroll: true,
      preserveState: true,
      ...options
    })
  }
  return {
    toggle
  }
}
