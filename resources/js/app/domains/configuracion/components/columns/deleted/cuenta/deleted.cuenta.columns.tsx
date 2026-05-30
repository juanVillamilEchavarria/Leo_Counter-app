/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { newColumns, type DeletedDomainColumnsProps } from "../utils/configuracion.deleted.columns.utils"
import { CuentaStaticColumns, type Cuenta } from "@/app/domains/cuenta"
/**
 * Instancia los parametros de las columnas de cuentas para el apartado de eliminados/archivados en configuracion
 * @param {Pick<newColumnsProps<Cuenta>, 'onSelect'>} {onSelect} 
 * @returns {SimpleTableColumn<Cuenta>[]}
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
export const deletedCuentaColumns =({
    onSelect
}:DeletedDomainColumnsProps<Cuenta>) =>{
    return newColumns<Cuenta>({
        onSelect:onSelect,
        columns: CuentaStaticColumns,
        columnsToRemove: ['active', 'actions', 'propietario', 'tipo_cuenta'],
    })
    
}