import { parseApiErrors } from "../../helpers";
import { AxiosError } from "axios";
import { type ApiErrorResponse } from "../../types/api";
import type { UseMutationResult } from "@tanstack/react-query";
export default function useMutationApiErrors(mutation : UseMutationResult) {
 const getErrorMessage = (): string | null => {
     if (!mutation.error) return null;
     const axiosError = mutation.error as AxiosError<ApiErrorResponse>;
     return (
       axiosError.response?.data?.message ||
       axiosError.message ||
       'Error desconocido'
     );
   };
   const getValidationErrors = (): Record<string, string> => {
     if (!mutation.error) return {};
     return parseApiErrors(mutation.error as AxiosError<ApiErrorResponse>);
   };

   return {
     getErrorMessage,
     getValidationErrors
   }
}
