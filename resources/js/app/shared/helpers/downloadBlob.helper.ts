/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

type BlobExtension = 'csv' | 'xlsx';

/**
 * Dispara la descarga de un blob en el navegador creando un enlace temporal.
 * @param blob - Blob binario del archivo a descargar.
 * @param filename - Nombre base del archivo (sin extensión).
 * @param extension - Extensión del archivo (csv o xlsx).
 */
export const downloadBlob = (blob: Blob, filename: string, extension: BlobExtension): void => {
  const url = window.URL.createObjectURL(blob);
  const link = document.createElement('a');
  link.href = url;
  link.setAttribute('download', `${filename}.${extension}`);
  document.body.appendChild(link);
  link.click();
  link.remove();
  window.URL.revokeObjectURL(url);
};