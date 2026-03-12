/**
 * Reportes Domain - Hooks
 * 
 * Este módulo contiene todos los hooks necesarios para la gestión de reportes.
 * Implementan principios SOLID y se integran con React Query para manejo asincrónico.
 */

// Form state management
export { useReporteForm, type FormErrors } from './useReporteForm';

// API mutations
export { useGenerateReportMutation } from './api/useGenerateReportMutation';

// API queries
export { default as useReporteFormOptionsApi } from './api/useReporteFormOptionsApi';
