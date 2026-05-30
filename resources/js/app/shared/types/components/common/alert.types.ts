/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
export const AlertMessagesTypes= {
    success: 'success',
    error: 'error'
}
export type AlertMessageProps={
    message: string | undefined,
    type?: keyof typeof AlertMessagesTypes
}