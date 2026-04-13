<?php

namespace App\Domains\Reporte\Contracts\Enums;

/**
 * Interfaz que deben extender todos los enums que definan los tipos de estadisticas de cada dominio de reporte,
 * para ser usados en la orquestación de consultas parciales y completas y asi obtener la estadistica correcta.
 * Ejemplo conceptual : MovimientoReportStatisticType::KPIS -> se refiere al tipo de dato estadistico que debe obtener el cual esta ligado al dominio Movimientos
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface ReportStatisticTypeContract
{
    // value() es implicito en enums de php
}