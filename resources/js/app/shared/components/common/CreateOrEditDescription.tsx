import Title from "./Title"
import TransitionMotion from '../transitions/TransitionMotion'
export default function CreateOrEditDescription({
    type,
    model
}:{
    type: 'create' | 'edit'
    model: string
}) {
  return (
    <TransitionMotion 
    initial={{x:-20, y:0, opacity:.5}}  
    transition={{
        duration: 0.35,
        ease: [0.22, 1, 0.36, 1], 
    }}  
    active={true} >
    <Title 
    size="2xl"
    className="text-center"
    title={
        (
            <>
            <span
            className={`
                    font-bold 
                    text-4xl
                    text-blue-700/70 rounded-sm border-b-2 border-blue-700
                `}
            >
                {
                    type === 'create' 
                    ? 'Crear' :
                    'Editar'
                }

            </span>
            <span className="text-muted-foreground text-4xl"> {model}</span>
            </>
        )
    } />
    </TransitionMotion>
  )
}
