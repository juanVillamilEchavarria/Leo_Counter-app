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
