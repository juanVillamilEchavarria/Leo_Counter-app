/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import Title from "../common/Title"
import { Head } from "@inertiajs/react"
import PageModeSelect from "../mode/PageModeSelect"
import GithubLink from "./GithubLink"
import { useMessageRedirect } from "../../hooks"

interface HeaderProps {
    isOpen: boolean
    setIsOpen: React.Dispatch<React.SetStateAction<boolean>>
    isMobileOpen: boolean
    setIsMobileOpen: React.Dispatch<React.SetStateAction<boolean>>
}

/**
 * Header principal.
 * Expone el botón hamburguesa solo en móvil/tablet para abrir o cerrar el
 * sidebar superpuesto sin afectar el colapso de escritorio.
 */
export default function Header({
    isMobileOpen,
    setIsMobileOpen,
}: HeaderProps) {
    const { props } = useMessageRedirect()
  return (
    <div className="w-full min-h-20 flex flex-row justify-between gap-3 bg-background shadow-xl items-center border-b border-border px-4 sm:px-6 lg:px-0">
        {props.title !== undefined && <Head title={props.title} />}
        <button
          type="button"
          className="lg:hidden inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-border bg-background text-foreground shadow-sm transition-colors hover:bg-accent"
          onClick={() => setIsMobileOpen(prev => !prev)}
          aria-label={isMobileOpen ? "Cerrar menú lateral" : "Abrir menú lateral"}
          aria-expanded={isMobileOpen}
        >
          <i className="fa-solid fa-bars" />
        </button>
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
              className="min-w-0 flex-1 truncate text-foreground lg:ml-10 font-principal whitespace-nowrap"
              />
              <div className="flex shrink-0 gap-2 sm:gap-4 items-center">
                  <PageModeSelect />
                  <GithubLink />
              </div>


    </div>
  )
}
