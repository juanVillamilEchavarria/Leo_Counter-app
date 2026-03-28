import jsPDF from "jspdf";
import { toPng } from "html-to-image";
import { ReporteDataSectionId } from "../types/reporte.types";
import { today } from "@/app/shared/helpers";
/**
 * Funcion para descargar el reporte actual de la interfaz como pdf
 * @returns pdf descargado
 */
export const downloadReport= async ()=>{
    const reportElement = document.getElementById(ReporteDataSectionId);
    if (!reportElement) throw new Error('No se pudo encontrar el elemento del reporte');
    const isDark = document.documentElement.classList.contains('dark');
    const imgData = await toPng(
        reportElement,
         {
             pixelRatio: 2 ,
              skipFonts: true,
              backgroundColor: isDark ? '#1f2937' : '#fff'
             }
        );
    const pdf = new jsPDF('p', 'mm', 'a4');
    const pageWidth = pdf.internal.pageSize.getWidth();
    const img = new Image();
    img.src = imgData;
    await new Promise(r => img.onload = r);
    const pageHeight = (img.height * pageWidth) / img.width;

    pdf.addImage(imgData, 'PNG', 0, 0, pageWidth, pageHeight);
    pdf.save(`reporte-${today()}.pdf`);
}