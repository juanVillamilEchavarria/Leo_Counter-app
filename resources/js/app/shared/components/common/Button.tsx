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
     <Tag onClick={onClick} type={type} className={` w-full p-2 rounded-2xl cursor-pointer ${ButtonVariants[variant]} ${className} ${disabled && 'cursor-not-allowed!'}`} disabled={disabled}>{children}</Tag>
  )
  if(Tag==='a' || Tag===Link )return(
     <Tag href={href} className={` w-full p-2 rounded-2xl cursor-pointer ${ButtonVariants[variant]} ${className}`}>{children}</Tag>

  )
  return null
}
