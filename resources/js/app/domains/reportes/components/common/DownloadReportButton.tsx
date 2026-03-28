import Button from "@/app/shared/components/common/Button"
import useDownloadReport from "../../hooks/utilities/useDownloadReport"

export default function DownloadReportButton() {
    const {loading, download} = useDownloadReport()
  return (
     <div className="w-full flex justify-end">
            <Button
            variant="clean" 
            className="hover:text-blue-500 transition-all text-foreground  hover:underline cursor-pointer"
            onClick={download}
            disabled={loading}
            >
              <i className="fa-solid fa-download text-xl"></i>
              <small className="">{loading ? "Descargando..." : "Descargar reporte"}</small>
            </Button>
    </div>
  )
}
