import { router } from '@inertiajs/react'
import { useModelToggle } from '@/app/shared/hooks'
import ToggleState from './ToggleState'
import { type ModelToggleProps } from '@/app/shared/types/components'


export default function ModelToggle({
  active,
  route,
  payload = {},
  labels
}: ModelToggleProps) {
 const { toggle } = useModelToggle({ route, payload })
  return (
    <ToggleState
      active={active}
      setActive={toggle}
      message={labels}
    />
  )
}
