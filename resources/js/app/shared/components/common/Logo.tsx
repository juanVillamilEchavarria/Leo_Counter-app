export default function Logo({
    className = ''
}) {
  return (
    <img src="/img/logo.jpg" className={`rounded-full ${className}`} alt="Logo" />
  )
}
