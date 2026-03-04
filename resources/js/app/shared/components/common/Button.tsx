import { type ButtonProps, ButtonVariants } from "@/app/shared/types/components"
import { Link } from "@inertiajs/react"
export default function Button({
  as : Tag = 'button',
    type = 'button',
    className = '',
    onClick = undefined,
    variant = 'primary',
    disabled = false,
    href = '#',
    children
}:ButtonProps) {
  if(Tag==='button')return(
     <Tag onClick={onClick} type={type} className={`  ${ButtonVariants[variant]} ${className} ${disabled && 'cursor-not-allowed!'}`} disabled={disabled}>{children}</Tag>
  )
  if(Tag==='a' || Tag===Link )return(
     <Tag href={href} className={`${ButtonVariants[variant]} ${className}`}>{children}</Tag>

  )
  return null
}
