/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */
interface NameAndEmailProps{
    name: string,
    email?: string
}
export default function NameAndEmail({
    name,
    email
}: NameAndEmailProps) {
  return (
    <div className="flex flex-col">
        <span className="font-medium text-foreground">{name}</span>
        {email && (
          <span className="text-xs text-muted-foreground">{email}</span>
        )}
      </div>
  )
}
