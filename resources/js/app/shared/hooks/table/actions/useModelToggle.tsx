import { router } from '@inertiajs/react'
export default function useModelToggle({
    route,
    payload = {}
}:{
    route: string
    payload?: Record<string, any>
}) {
    const toggle = () => {
    router.patch(route, payload, {
      preserveScroll: true,
      preserveState: true,
    })
  }
  return {
    toggle
  }
}
