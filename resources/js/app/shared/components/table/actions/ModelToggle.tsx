/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
