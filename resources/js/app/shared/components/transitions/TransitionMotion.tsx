import { motion, AnimatePresence, animate } from 'framer-motion'
import { type TransitionMotionProps } from '../../types/components'


// este transition moution, toma un valor de active, que es el que activa la transition, se le debe pasar mediante el elemento padre
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
    }
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
