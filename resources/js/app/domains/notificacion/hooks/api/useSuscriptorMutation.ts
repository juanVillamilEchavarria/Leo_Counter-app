import { useMutation } from '@tanstack/react-query';
import useMutationApiErrors from '@/app/shared/hooks/api/useMutationApiErrors';
import { SuscriptorApiActions, type SuscriptorApiAction, type SuscriptorFormData} from '../../types/notificacion.types';
import type {SuscriptorApiResponse} from "@/app/domains/notificacion/api/notificacion.api";
import type { AxiosError } from 'axios';
import type { ApiErrorResponse } from '@/app/shared/types/api';

/**
 * Props para el hook useSuscriptorMutation
 */
interface UseSuscriptorMutationProps {
    action: SuscriptorApiAction;
    id?: string; // requerido para update y delete
    onSuccess?: (data?: SuscriptorApiResponse | void) => void;
    onError?: (errors: AxiosError<ApiErrorResponse>) => void;
}

/**
 * Hook para manejar la mutación de suscriptores de notificación
 * @param param0
 * @param param0.action
 * @param param0.id
 * @param param0.onSuccess
 * @param param0.onError
 */
export function useSuscriptorMutation({
action,
id,
onSuccess,
onError
}: UseSuscriptorMutationProps) {
    /**
     * Función que maneja la mutación de suscriptores de notificación
     * @param data
     */
    const mutationFn = async (data?: SuscriptorFormData) => {
        switch (action) {
            case 'create':
                if (!data) throw new Error('Data requerida para crear');
                return SuscriptorApiActions.create(data);
            case 'delete':
                if (!id) throw new Error('ID requerido para eliminar');
                return SuscriptorApiActions.delete(id);
        }
    };

    const mutation = useMutation({
        mutationFn,
        onSuccess: (result) => {
            if (onSuccess) onSuccess(result);
        },
        onError: (error: AxiosError<ApiErrorResponse>) => {
            if (onError) onError(error);
        },
    });

    const { getErrorMessage, getValidationErrors } = useMutationApiErrors(mutation as any);

    return {
        mutate: async (formData?: SuscriptorFormData) => {
            try {
                return await mutation.mutateAsync(formData);
            } catch {}
        },
        isPending: mutation.isPending,
        isSuccess: mutation.isSuccess,
        isError: mutation.isError,
        error: getErrorMessage(),
        validationErrors: getValidationErrors(),
        reset: mutation.reset,
    };
}
