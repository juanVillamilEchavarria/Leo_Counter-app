/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
import React from 'react'

/**
 * Componente para mostrar en la tabla de auditoria el tipo de accion realizada
 * @param param0 
 * @returns 
 */
export default function ActionOutput({
    action
}:{
    action: string
}) {
    const output = action === 'create'? 'creado' : action === 'update'? 'actualizado' : 'eliminado'

    const color = action === 'create'? 'text-green-500' : action === 'update'? 'text-blue-500' : 'text-red-500'
  return (
    <p className={color}>{output}</p>
  )
}
