import Title from "../common/Title"
import { Head } from "@inertiajs/react"
import { useMessageRedirect } from "../../hooks"
export default function Header() {
    const { props } = useMessageRedirect()
  return (
    <div className="w-full h-20 flex lg:flex-row flex-col justify-between bg-background shadow-xl items-center border-b border-border ">
        <Head>
          <title>{props.title}</title>
       </Head>
        <Title title={
                  props.NoRegistros ? (
                    <>
                      {props.title}
                      <span className="mx-2 text-foreground ">&middot;</span>
                      <span className="text-sm">
                        {props.NoRegistros} {props.NoRegistros === 1 ? 'registro' : 'registros'}
                      </span>
                    </>
                  ) : (
                    props.title
                  )
              }    
              size="md" 
              className=" text-foreground ml-10 font-principal whitespace-nowrap" 
              />
        <div className="flex gap-2 items-center mr-4 text-foreground">
          {/* enlace a github con el icono */}
            <i className="fa-brands fa-github text-2xl"></i>
            <a href={import.meta.env.VITE_GITHUB_REPOSITORY} target="_blank" rel="noopener noreferrer">Leo Counter</a>
        </div>

    </div>
  )
}
