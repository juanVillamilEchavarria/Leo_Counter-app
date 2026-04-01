import ActionSection from "@/app/shared/components/table/actions/ActionSection";
import {type Cuenta } from "@/app/domains/cuenta";
import { removeColumns } from "../../../../helpers/configuracion.helpers";
import CrudButton from "@/app/shared/components/common/CrudButton";
import Button from "@/app/shared/components/common/Button";
import {type ButtonProps } from "@/app/shared/types/components";
import {type CrudButtonProps, type SimpleTableColumn } from "@/app/shared/types/components";
import type { CategoriaTableData } from "@/app/domains/categoria";
/**
 * Interface que guarda los dominios que hacen softdeletes y que pueden ser recuperados o eliminados
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface SoftDeletedDomainTypes {
    cuenta : Cuenta
    categoria : CategoriaTableData
}
/**
 * Tipo que define el dominio de la tabla de archivo/eliminado
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
type SoftDeleteDomain = keyof SoftDeletedDomainTypes

/**
 * Contrato el cual deben cumplir los props de todas las columnas de las tablas de archivo/eliminado en configuracion
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
export interface DeletedDomainColumnsProps<TData extends SoftDeletedDomainTypes[SoftDeleteDomain]> extends Pick<newColumnsProps<TData>, 'onSelect'>{}
/**
 * Tipo que define los modales soportados en la tabla de archivo/eliminado
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
export type DeletedDomainModalTypes = 'restore' | 'destroy'


/**
 * Instancia los parametros de los botones de recuperar y eliminar
 * @param {SoftDeleteDomain} item 
 * @param {(item: SoftDeleteDomain, modal: string)=> void} onSelect 
 * @returns {CrudButtonProps[]}
 *  @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
export const softDeletedTableActions =<TData extends  SoftDeletedDomainTypes[SoftDeleteDomain]> 
    (
    item : TData, 
    onSelect :(item: TData, modal: DeletedDomainModalTypes)=> void
    ): CrudButtonProps[] =>{
    return[
    {
        Crudvariant: 'Create',
        withSpan: false,
        className: 'h-full p-2! m-0! text-xs!',
        icon:'fa-solid fa-arrow-rotate-left',
        onClick: () => onSelect(item, 'restore'),
    },
    {
        Crudvariant: 'Delete',
        className: 'h-full',
        icon:'fa-solid fa-trash-can',
        onClick: () => onSelect(item, 'destroy'),
    }

]
}
/**
 * Interface que define los parametros de la funcion newColumns
 *  @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface newColumnsProps <TData extends  SoftDeletedDomainTypes[SoftDeleteDomain]>{
    onSelect:(item: TData, modal: DeletedDomainModalTypes)=> void 
    columns : SimpleTableColumn<TData>[]
    columnsToRemove : string[]
    
}
/**
 * Crea las nuevas columnas del dominio especificado, implementando las acciones para restaurar y eliminar el registro
 * @param {newColumnsProps} {onSelect, columns} 
 * @returns {SimpleTableColumn[]}
  * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
export const newColumns = <TData extends  SoftDeletedDomainTypes[SoftDeleteDomain]>
    ({
        onSelect,
        columns,
        columnsToRemove
    }:newColumnsProps<TData>): SimpleTableColumn<TData>[]=>{
    const columnsFormated = removeColumns<TData>(columns, columnsToRemove) 

    return [
        ...columnsFormated,
        {
            key: 'actions',
            label: '',
            render: (row : TData)=>{
                return <ActionSection
                    actions={softDeletedTableActions<TData>(row, onSelect)}
                    as={CrudButton}
                />
            }
        }
    ]

    }
/**
 * Funcion para instanciar las columnas del dominio 
 * @param item 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
export const onSelectDefault = <TData extends SoftDeletedDomainTypes[SoftDeleteDomain]>
 (_item: TData, _modal?: string): void => {}
