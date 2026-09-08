/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import React from 'react'

export default function useSubmitWithId({
    itemId,
    execute
}:{
    itemId: string | null | undefined,
    execute: (id: string) => void
}) {
    const submit = async ()=>{
        if(!itemId) return 
        await execute(itemId)
    }
    return {
        submit
    }
}
