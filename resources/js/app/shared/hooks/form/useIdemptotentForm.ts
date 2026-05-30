/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useForm } from '@inertiajs/react';
import {useRef} from "react";
import {generateIdempotencyKey} from "@/app/shared/helpers/form/idempotency.helpers";

/**
 * Hook para manejar formularios y request utilizando idempotencia
 *
 * @param initialData
 */
export function useIdempotentForm<TForm extends Record<string, any>>(initialData?: TForm) {
    const form = useForm<TForm>(initialData as TForm);

    const idempotencyKey = useRef(generateIdempotencyKey());
    const resetIdempotencyKey = () => {
        idempotencyKey.current = generateIdempotencyKey();
    };
    const idempotentPost = (url: string, options?: Parameters<typeof form.post>[1]) => {

        form.post(url, {
            ...options,
            headers: {
                ...options?.headers,
                'Idempotency-Key': idempotencyKey.current,
            },
            onSuccess: (page)=>{
                resetIdempotencyKey();
                if (options?.onSuccess) options.onSuccess(page);
            }
        });

    };

    const idempotentPut = (url: string, options?: Parameters<typeof form.put>[1]) => {
        form.put(url, {
            ...options,
            headers: {
                ...options?.headers,
                'Idempotency-Key': idempotencyKey.current,
            },
            onSuccess: (page)=>{
                resetIdempotencyKey();
                if (options?.onSuccess) options.onSuccess(page);
            }
        });
    };

    const idempotentDelete = (url: string, options?: Parameters<typeof form.delete>[1]) => {
        form.delete(url, {
            ...options,
            headers: {
                ...options?.headers,
                'Idempotency-Key': idempotencyKey.current,
            },
            onSuccess: (page)=>{
                resetIdempotencyKey();
                if (options?.onSuccess) options.onSuccess(page);
            }
        });
    };


    return {
        form,
        idempotentPost,
        idempotentPut,
        idempotentDelete,
    };
}
