/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import {
    CanalNotificacionActions,
    NotificacionToggleTypes,
    SuscriptorNotificacionActions, type SuscriptorTableData
} from '../../types/notificacion.types'
import ModelToggle from '@/app/shared/components/table/actions/ModelToggle'
import CrudButton from '@/app/shared/components/common/CrudButton'
import type { SimpleTableColumn } from '@/app/shared/types/components'
import type {PresupuestoMesActualTableData} from "@/app/domains/presupuestoMesActual";

/**
 * Columnas para la tabla de suscriptores de notificación.
 * Incluye toggle de activo con ModelToggle y botones CRUD.
 * Sigue el patrón de cuenta.columns.tsx.
 * @param {object} params
 * @param {Function} params.onSelect - Callback para abrir modales (edit/delete)
 * @returns {SimpleTableColumn<SuscriptorTableData>[]}
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.1.0
 */
export const SuscriptorColumns = ({
  onSelect
}: {
  onSelect: (item: SuscriptorTableData, modalType: string) => void
}): SimpleTableColumn<SuscriptorTableData>[] => [
  { key: 'id', label: 'ID' },
  { key: 'usuario', label: 'Usuario'},
  { key: 'canal', label: 'Canal' },
    {
        key: 'verified',
        label: 'Verificado',
        className : 'text-center',
        render: (row: SuscriptorTableData) => (
            <i className={`fa-regular ${row.verified ? 'fa-circle-check text-green-400' : 'fa-circle-xmark text-red-400'} text-2xl`}></i>

        )
    },
  {
    key: 'activo',
    label: 'Activo',
    className: 'w-40',
    render: (row: SuscriptorTableData) => (
      <ModelToggle
        active={row.active}
        route={SuscriptorNotificacionActions.toggle(row.id, NotificacionToggleTypes.active)}
      />
    )
  },
  {
    key: 'actions',
    label: '',
    render: (row: SuscriptorTableData) => (
      <div className="flex gap-2">
        <CrudButton Crudvariant="Delete" onClick={() => onSelect(row, 'delete')} />
      </div>
    )
  }
]
