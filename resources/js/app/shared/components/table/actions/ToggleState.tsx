/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
// ajustar tamaño y espacio en el elemento padre del toggle
// after es la bolita que se mueve
// este es el switch para hacer patch a un estado de algun modelo desde la tabla
interface ToggleStateProps{
   active?:boolean,
    setActive:()=>void | undefined | void,
    message?:{
        active?:string,
        inactive?:string
    }
}
/**
 * Componente de switch, su tamaño y espacio se ajusta en el elemento padre
 * @param {boolean} active 
 * @param {() => void | undefined | void} setActive 
 * @param {{ active?: string; inactive?: string; }} message
 * @returns 
 */
export default function ToggleState({
    active = false,
    setActive,
    message={
        active: 'Activo',
        inactive: 'Inactivo'
    }
}:ToggleStateProps) {
  return (
    <label className="inline-flex items-center cursor-pointer">
                    <input 
                        type="checkbox" 
                        value="" 
                        checked={active} 
                        className="sr-only peer text-foreground" 
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
                    after:bg-background 
                    dark:after:bg-muted
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
                        'text-green-600/40 dark:text-green-200' 
                        : 
                        'text-red-600/40 dark:text-red-200'}
                        `
                        }>{active ? message.active : message.inactive}</span>
                  </label>
  )
}
