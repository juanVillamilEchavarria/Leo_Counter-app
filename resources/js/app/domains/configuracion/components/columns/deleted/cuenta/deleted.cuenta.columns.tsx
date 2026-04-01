import { newColumns, type DeletedDomainColumnsProps, onSelectDefault } from "../utils/configuracion.deleted.columns.utils"
import { CuentaColumns, type Cuenta } from "@/app/domains/cuenta"
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
        columns: CuentaColumns({
            onSelect: onSelectDefault<Cuenta>
        }),
        columnsToRemove: ['active', 'actions']
    })
    
}