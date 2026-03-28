import ActiveReportIteraibleFilter from './ActiveReportIteraibleFilter'
import { useOpen } from '@/app/shared/hooks'
import Button from '@/app/shared/components/common/Button'

interface ActiveReportFiltersProps {
  periodo: string
  categorias: string | string[]
  cuentas: string | string[]
  onReset: () => void
  isResetting?: boolean
}

export default function ActiveReportFilters({
  periodo,
  categorias,
  cuentas,
  onReset,
  isResetting = false
}: ActiveReportFiltersProps) {
  const { isOpen, setIsOpen } = useOpen(false)
  const { isOpen: isOpenCuentas, setIsOpen: setIsOpenCuentas } = useOpen(false)

  return (
    <div className="bg-background rounded-lg border border-border p-4 mb-6">
      <div className="flex items-center gap-4 mb-4">
        <h4 className="font-semibold text-foreground">Filtros activos</h4>
        <div className="w-1/12">
          <Button
            type="button"
            variant="secondary"
            onClick={onReset}
            disabled={isResetting}
            className="flex items-center gap-2 text-sm px-3 py-1"
          >
            <i className="fa-solid fa-rotate-left"></i>
            {isResetting ? 'Restableciendo...' : 'Restablecer'}
          </Button>
        </div>

      </div>

      <ul className="space-y-2">
        <li className="flex items-center gap-2 text-muted-foreground">
          <i className="fa-solid fa-calendar text-blue-500"></i>
          <span>{periodo}</span>
        </li>
        <li>
          {Array.isArray(categorias) ? (
            <ActiveReportIteraibleFilter
              setIsOpen={setIsOpen}
              isOpen={isOpen}
              iterable={categorias}
              title="Categorias seleccionadas"
            />
          ) : (
            <>
              <i className="fa-solid fa-tag text-orange-500"></i>
              <span className="text-muted-foreground"> {categorias}</span>
            </>
          )}
        </li>
        <li>
          {Array.isArray(cuentas) ? (
            <ActiveReportIteraibleFilter
              setIsOpen={setIsOpenCuentas}
              isOpen={isOpenCuentas}
              iterable={cuentas}
              title="Cuentas seleccionadas"
            />
          ) : (
            <>
              <i className="fa-solid fa-tag text-orange-500"></i>
              <span className="text-muted-foreground"> {cuentas}</span>
            </>
          )}
        </li>
      </ul>
    </div>
  )
}
