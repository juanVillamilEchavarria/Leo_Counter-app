export const AlertMessagesTypes= {
    success: 'success',
    error: 'error'
}
export type AlertMessageProps={
    message: string | undefined,
    type?: keyof typeof AlertMessagesTypes
}