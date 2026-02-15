import SuccessOrFailText from "@/app/shared/components/common/SuccessOrFailText"

export default function SaldoValidationFeedback({
    allowed
}:{
    allowed?: boolean
}) {
  return (
     <SuccessOrFailText attribute={allowed} value={false} output={(
            <div
            className={`flex items-center gap-2 
            ${allowed === true ? 
            'text-green-500' : 
            'text-red-500'} 
            text-sm mt-1`}
        >
                <i className={`fas ${allowed === true ? 'fa-check-circle' : 'fa-times-circle'}`}></i>
                <span>{allowed === true ? 'Saldo disponible' : 'Saldo insuficiente'}</span>
            </div>
        )} />
  )
}
