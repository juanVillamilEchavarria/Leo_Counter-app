import useReporteFormOptionsApi from "./useReporteFormOptionsApi"
export default function useReporteFormOptions() {
  const {data}= useReporteFormOptionsApi()
  return data
}
