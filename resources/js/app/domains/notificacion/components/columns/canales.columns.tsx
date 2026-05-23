import {
    NotificacionToggleTypes,
    type CanalNotificacion,
    CanalNotificacionActions
} from "@/app/domains/notificacion";
import type {SimpleTableColumn} from "@/app/shared/types/components";
import ModelToggle from "@/app/shared/components/table/actions/ModelToggle";
import CrudButton from "@/app/shared/components/common/CrudButton";

export const CanalesColumns = (): SimpleTableColumn<CanalNotificacion>[] => [
    { key: 'id', label: 'ID' },
    { key: 'nombre', label: 'Nombre' },
    {
        key: 'active',
        label: 'Active',
        className: 'w-40',
        render: (row: CanalNotificacion) => (
            <ModelToggle
                active={row.active}
                route={CanalNotificacionActions.toggle(row.id, NotificacionToggleTypes.active)}
            />
        )
    }
]
