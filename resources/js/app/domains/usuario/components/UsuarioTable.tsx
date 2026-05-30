/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import SimpleTable from "@/app/shared/components/table/simple/SimpleTable";
import { useSimpleTable } from "@/app/shared/hooks";
import { UsuarioColumns } from "./columns/usuario.columns";
import { type Usuario } from "../types/usuario.types";
import { useMemo } from "react";

/**
 * Componente de tabla para el listado de usuarios en administración.
 * Renderiza una SimpleTable con columnas de usuario y acciones de edición/eliminación.
 * @param data - Array de usuarios a mostrar.
 * @param onSelect - Callback que se ejecuta al seleccionar un usuario (para modal de eliminación).
 * @param pageSize - Número de registros por página (por defecto 10).
 */
export default function UsuarioTable({
  pageSize = 10,
  data,
  onSelect
}: {
  pageSize?: number,
  data: Usuario[],
  onSelect: (item: Usuario, modalType: string) => void
}) {
  const columns = useMemo(() => {
    return UsuarioColumns({
      onSelect: (item: Usuario) => {
        onSelect(item, 'delete')
      }
    })
  }, [onSelect])

  return (
    <SimpleTable
      data={data}
      columns={columns}
      pagination={true}
      pageSize={pageSize}
    />
  )
}
