import Title from "./Title"
export default function CreateOrEditDescription({
    type,
    model
}:{
    type: 'create' | 'edit'
    model: string
}) {
  return (
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
                    ${type === 'create' ?
                    'text-green-700/70 rounded-sm border-b-2 border-green-700' :
                    'text-blue-700/70 rounded-sm border-b-2 border-blue-700'}
                `}
            >
                {
                    type === 'create' 
                    ? 'Crear' :
                    'Editar'
                }

            </span>
            <span className="text-gray-600 text-4xl"> {model}</span>
            </>
        )
    } />
  )
}
