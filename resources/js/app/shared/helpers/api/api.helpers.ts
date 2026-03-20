import { AxiosError } from "axios";
import { type ApiErrorResponse } from "../../types/api";
export const parseApiErrors = (error: AxiosError<ApiErrorResponse>): Record<string, string> | AxiosError => {
  const result : Record<string, string> = {};

  if (error.response?.data?.errors) {
    Object.entries(error.response.data.errors).forEach(([key, messages]) => {
      // toma el primer mensaje de cada campo
      result[key] = Array.isArray(messages) ? messages[0] : String(messages);
    });
  }else{
    return error
  }

  return result;
};