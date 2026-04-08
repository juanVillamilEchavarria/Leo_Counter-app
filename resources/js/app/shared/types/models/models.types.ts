/**
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
/**
 * Interfaz que representa un modelo con timestamps
 */
export interface TimeStampModel {
    created_at: string
    updated_at: string
}
/**
 * Interfaz que representa un modelo con timestamps y softdelete
 */
export interface TimeStampModelWithSoftDelete extends TimeStampModel {
    deleted_at: string
}
/**
 * Interfaz que representa un modelo con timestamps y softdelete que puede ser eliminado permanentemente
 */
export interface SoftDeleteModel extends TimeStampModelWithSoftDelete{
    can_hard_delete: boolean
}