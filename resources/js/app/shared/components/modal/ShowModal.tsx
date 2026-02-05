import Modal from "./Modal"
import { BaseIcons } from "../../types"
export default function ShowModal({
    tittle,
    spanTittle = 'Detalles',
    open,
    item,
    icons = BaseIcons,
    onClose,
    children
}:{
    tittle : string,
    spanTittle? : string
    children : React.ReactNode
    open: boolean,
    item : Record<string, any> | null
    icons? : Record<string, string>
    onClose: () => void
}) {
  return (
    <Modal
    open={open}
    onClose={onClose}
    size="xl"
    variant="secondary"
    className="overflow-y-scroll scrollbar-modern"
    title={
        <div className="w-full flex justify-start">
            <p className="text-4xl">
                 <span className="text-blue-400 border-b-2 border-blue-500 rounded-lg">{spanTittle} ~ </span>
              {tittle}
            </p>
           
        </div>
    }
    >
      <div className="flex flex-col h-full w-full my-2">  
            <ul className=" relative grid grid-cols-2 gap-4 my-6 border-y-2 py-4 border-blue-200/10">
            <span className="pointer-events-none absolute top-4 bottom-4 left-1/2  w-px bg-blue-200/10" />
            {item &&
                Object.entries(item).map(([key, value]) => { 
                console.log(value)
                const icon = icons[key] ?? 'fa-solid fa-circle-question' 
                return (
                <li key={key} className="ml-2 text-lg flex gap-2 items-center ">
                    
                    {!Array.isArray(value)&&(
                    <>
                    <button className="bg-blue-200/20 p-2 rounded-3xl flex items-center " disabled={true}>
                    <i className={`${icon}`}></i>
                    </button>
                    <p><span className="font-bold capitalize">{key.replaceAll('_', ' ')}</span>: {value} </p>
                    </>

                    )}
                    
                    </li>
                )})
            }
            </ul>
            {children}
        </div>
        
    </Modal>
  )
}
