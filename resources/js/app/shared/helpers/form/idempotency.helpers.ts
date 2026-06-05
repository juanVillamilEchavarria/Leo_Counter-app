import { v4 as uuidv4 } from 'uuid';
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
/**
 * Funcion que genera una llave de idempotencia unica.
 * @returns 
 */
export function generateIdempotencyKey(): string {
    return uuidv4();
}