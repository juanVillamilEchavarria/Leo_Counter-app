// ajustar tamaño y espacio en el elemento padre del toggle
// after es la bolita que se mueve
// este es el switch para hacer patch a un estado de algun modelo desde la tabla
export default function ToggleState({
    active = false,
    setActive,
    message={
        active: 'Activo',
        inactive: 'Inactivo'
    }
}:{
    active?:boolean,
    setActive:()=>void | undefined | void,
    message?:{
        active?:string,
        inactive?:string
    }
}) {
  return (
    <label className="inline-flex items-center cursor-pointer">
                    <input 
                        type="checkbox" 
                        value="" 
                        checked={active} 
                        className="sr-only peer" 
                        onChange={setActive} 
                    />
                    
                    <div className={`
                      relative
                      transition-all
                      duration-300
                      w-12
                      h-6
                      ${active ? 
                        ` bg-green-200
                      border-green-400/60`:
                        `bg-red-200
                      border-red-400/60` 
                      }
                      border-2
                      rounded-full 
                      peer 
                      peer-checked:after:translate-x-[1.45rem] 
                      peer-checked:after:border-buffer 
                      after:content-[''] 
                      after:absolute 
                      after:top-0 
                      after:start-0
                    after:bg-white 
                      after:rounded-full
                      after:h-5 
                      after:w-5 
                      after:transition-all 
                      after:duration-400
                      peer-checked:bg-brand
                      `}></div>
                    <span 
                    
                    className={`
                        text-xs 
                        font-bold 
                        w-6 
                        ml-2 
                        ${active ? 
                        'text-green-600/40' 
                        : 
                        'text-red-600/40'}
                        `
                        }>{active ? message.active : message.inactive}</span>
                  </label>
  )
}
