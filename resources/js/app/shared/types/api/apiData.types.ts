/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
export type SaldoValidateCuentaData={
    cuenta_id: number,
    monto: number
}

export type SaldoValidateResponse ={
    allowed: boolean
}