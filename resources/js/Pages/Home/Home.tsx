import { KPISection, BalanceLineChart } from "@/app/domains/reportes"
import Loading from "@/app/shared/components/common/Loading"
import ErrorResponse from "@/app/shared/components/common/ErrorResponse"
import EmptyDataMessage from "@/app/domains/reportes/components/common/EmptyDataMessage"
import { useHome, HomeSection, IngresoAndGastoLineChart } from "@/app/domains/home"
export default function Home() {
  const {data, isLoading, error}= useHome()
  console.log(data?.data.KPIs);

  if(isLoading){
    return (
      <HomeSection >     
          <Loading text="Cargando" paragraph="Estamos Cargando Tus Reportes" />
      </HomeSection>
    )
    
  }
  if(error){
    return (
      <HomeSection >     
          <ErrorResponse text="Error" paragraph="Error al cargar tus reportes" />
      </HomeSection>
    )
  }
  if(!data?.data){
    return (
       <HomeSection >     
         <EmptyDataMessage title="No hay datos disponibles" paragraph="genera movimientos para ver tus resumenes" />
      </HomeSection>

    )
   
  }
  const {KPIs, tendencia} = data.data
  console.log(KPIs);
  console.log(tendencia);
  return (
  
    <HomeSection>

    <KPISection kpis={KPIs} />
          <IngresoAndGastoLineChart data={tendencia.ingresos_vs_gastos} />
     </HomeSection>

  )
}
