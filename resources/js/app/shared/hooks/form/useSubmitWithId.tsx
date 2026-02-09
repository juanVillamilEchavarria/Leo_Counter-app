import React from 'react'

export default function useSubmitWithId({
    itemId,
    execute
}:{
    itemId: number | null | undefined,
    execute: (id: number) => void
}) {
    const submit = async ()=>{
        if(!itemId) return 
        await execute(itemId)
    }
    return {
        submit
    }
}
