<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Http\Controllers\ArchivoMovimiento;

use App\Http\Controllers\Controller;
use App\Models\ArchivoMovimiento\ArchivoMovimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchivoMovimientoController extends Controller
{
    public function show(ArchivoMovimiento $archivoMovimiento){
        return Storage::disk($archivoMovimiento->disk)->response($archivoMovimiento->path . $archivoMovimiento->nombre_guardado);
    }

    public function download(ArchivoMovimiento $archivoMovimiento){
        return Storage::disk($archivoMovimiento->disk)->download($archivoMovimiento->path . $archivoMovimiento->nombre_guardado);
    }
}
