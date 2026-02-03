export default function SuccessOrFailText({
    attribute,
    value
}:{
    attribute: string,
    value: string
}) {
  return (
    <span className={`${attribute === value ? 'text-green-600' : 'text-red-400'}`}>{attribute}</span>
  )
}
