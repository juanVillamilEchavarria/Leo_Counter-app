import Tittle from "../Tittle"
import { Head } from "@inertiajs/react"
import { useMessageRedirect } from "../../hooks"
export default function Header() {
    const { props } = useMessageRedirect()
    
    
  return (
    <div className="w-full h-20 flex justify-between bg-white shadow-2xl items-center ">
        <Head>
          <title>{props.tittle}</title>
       </Head>
        <Tittle tittle={
                  props.NoRegistros ? (
                    <>
                      {props.tittle}
                      <span className="mx-2 text-gray-400">&middot;</span>
                      <span className="text-sm text-gray-500">
                        {props.NoRegistros} registros
                      </span>
                    </>
                  ) : (
                    props.tittle
                  )
              }    
              size="md" 
              className=" text-azul-negro ml-10 font-principal whitespace-nowrap" 
              />
        <div className="flex gap-2 items-center mr-4">
          {/* enlace a github con el icono */}
            <i className="fa-brands fa-github text-2xl"></i>
            <a href={import.meta.env.VITE_GITHUB_REPOSITORY} target="_blank" rel="noopener noreferrer">Leo Counter</a>
        </div>

    </div>
  )
}
