import useReporteFormOptionsApi from "../api/useReporteFormOptionsApi"
export default function useReporteFormOptions() {
  const {data}= useReporteFormOptionsApi()
  return data
}
