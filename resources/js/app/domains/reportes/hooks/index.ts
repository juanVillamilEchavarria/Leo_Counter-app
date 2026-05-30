/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
/**
 * Reportes Domain - Hooks
 * 
 * Este módulo contiene todos los hooks necesarios para la gestión de reportes.
 * Implementan principios SOLID y se integran con React Query para manejo asincrónico.
 */

// Form state management
export { useReporteForm, type FormErrors } from './Form/useReporteForm';

// API mutations
export { useGenerateReportMutation } from './api/useGenerateReportMutation';

// API queries
export { default as useReporteFormOptionsApi } from './api/useReporteFormOptionsApi';
