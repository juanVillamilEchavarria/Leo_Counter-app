/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */
import { apiRequest } from '@/app/shared/api/client.api';
import type { ExportParams } from '../types/exportacion.types';
import type { AxiosError } from 'axios';
import type { ApiErrorResponse } from '@/app/shared/types/api';

/**
 * Envía una petición de exportación al backend y retorna el blob del archivo.
 * Requiere responseType: 'blob' para manejar correctamente la respuesta binaria.
 */
export const exportDataApi = async (params: ExportParams): Promise<Blob> => {
  try {
      return await apiRequest<Blob, ExportParams>({
      method: 'post',
      url: 'export',
      data: params,
      responseType: 'blob',
    });
    
  } catch (error : any) {
     if (error.response?.data instanceof Blob) {
      const text = await error.response.data.text();
      try {
        const jsonError = JSON.parse(text);
        error.response.data = jsonError;
      } catch {}
    }
    throw error;
  }
    
  
 
};