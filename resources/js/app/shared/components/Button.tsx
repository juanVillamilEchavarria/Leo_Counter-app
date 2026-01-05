import { type ButtonProps, ButtonVariants } from "@/app/shared/types/components"
export default function Button({
    type = 'button',
    className = '',
    variant = 'primary',
    disabled = false,
    children
}:ButtonProps) {
  return (
    <button type={type} className={` w-full ${ButtonVariants[variant]} ${className}`} disabled={disabled}>{children}</button>
  )
}
