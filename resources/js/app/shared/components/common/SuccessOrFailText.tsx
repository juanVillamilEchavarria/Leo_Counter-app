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
