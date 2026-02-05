export function moneyFormat(amount: number) {
    return amount.toLocaleString('es-CO', { style: 'currency', currency: 'COP' , minimumFractionDigits: 2,
    maximumFractionDigits: 2,});
}