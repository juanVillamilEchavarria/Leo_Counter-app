import { type AlertMessageProps } from "../../types/components"
import useMessage from "../../hooks/messages/useMessage"
export default function AlertMessage({
    message,
    type = 'error'
}:AlertMessageProps) {
    const BaseStyles= `p-2 border-l-4 rounded-lg transition-all duration-300 ease-out
        animate-fade-in
      ${type === 'success' ? 'bg-green-300 border-green-800' : 'bg-red-300 border-red-800'}
    `
    return (
        <div className={BaseStyles}>
            <p className="text-sm">{message}</p>
        </div>
    )
}
