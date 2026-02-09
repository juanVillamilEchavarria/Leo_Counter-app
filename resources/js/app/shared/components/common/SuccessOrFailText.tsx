export default function SuccessOrFailText({
    attribute,
    value,
    output

}:{
    attribute: string | number | boolean,
    value: string
    output ? : string | React.ReactNode
}) {
  return (
    <span className={`${attribute === value ? 'text-green-600' : 'text-red-400'}`}>{output ?? attribute}</span>
  )
}
