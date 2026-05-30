/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
export default function SuccessOrFailText({
  as : Tag = 'span',
  className = '',
    attribute,
    value,
    output

}:{
    as?: React.ElementType
    className?: string
    attribute: string | number | boolean | undefined,
    value: string | number | boolean
    output ? : string | React.ReactNode
}) {
  return (
    <Tag className={`${attribute === value ? 'text-green-600' : 'text-red-400'} ${className}`}>{output ?? attribute}</Tag>
  )
}
