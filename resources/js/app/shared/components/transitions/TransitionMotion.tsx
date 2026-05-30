/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { motion, AnimatePresence, animate } from 'framer-motion'
import { type TransitionMotionProps } from '../../types/components'


/**
 * Componente de transición para animar elementos
 * @param {boolean} active - Indica si la transición está activa o no
 * @param {React.ReactNode} children - Elementos hijos a los que se les aplicará la transición
 * @param {string} className - Clases CSS adicionales para el contenedor de la transición
 * @param {'position' | 'size' | 'layout'} layout - Tipo de animación de layout a aplicar (opcional, por defecto 'position')
 * @param {object} initial - Estado inicial de la animación (opcional, por defecto { opacity: 0, x: 0, y: 0 })
 * @param {object} animate - Estado final de la animación (opcional, por defecto { opacity: 1, x: 0, y: 0 })
 * @param {object} exit - Estado de salida de la animación (opcional, por defecto { opacity: 0, x: -40, y: 0 })
 * @param {object} transition - Configuración de la transición (opcional, por defecto { duration: 0.25 })
 * @param {object} style - Estilos adicionales para el contenedor de la transición (opcional) 
 * @returns {JSX.Element} Componente de transición que envuelve a los elementos hijos y les aplica la animación definida
 */
export default function TransitionMotion({
    active,
    children,
    className='',
    layout = 'position',
    initial ={
        opacity: 0,
        x: 0,
        y: 0,
       
        
    },
    animate={
        opacity: 1,
        y: 0,
        x: 0,
        

    },
    exit ={
        opacity: 0,
        x: -40,
        y: 0,
        
    },
    transition={
        duration: 0.25
    },
    style={}
}: TransitionMotionProps) {
  return (
    <AnimatePresence >
        {active && 
            <motion.div
                layout = {layout}
                initial={initial}
                animate={animate}
                exit={exit}
                transition={transition}
                className= {className}
            >
                {children}
            </motion.div>
        }
    </AnimatePresence>
  )
}
