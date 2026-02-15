<?php

namespace App\Console\Commands\Files;

use App\Models\ArchivoMovimiento\ArchivoMovimiento;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanOrphanFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:clean-orphan-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Eliminacion de archivos huerfanos que no estan asociados a ningun movimiento';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $disk = $this->ask('Ingrese el disco donde se encuentran los archivos (ej: movimientos)');
        $registeredFiles = $this->getRegisteredFiles($disk);
        $storageFiles = Storage::disk($disk)->allFiles();
        $orphanFiles = array_diff($storageFiles, $registeredFiles);
        if(empty($orphanFiles)){
            $this->info("No se encontraron archivos huerfanos en el disco {$disk}");
            return;
        }
        foreach($orphanFiles as $file){
            $this->line("Archivo encontrado: {$file}");
            $this->line("Se encontraron " . count($orphanFiles) . " archivos huerfanos en el disco {$disk}.");
        }
        if($this->confirm("Desea eliminarlos?")) {

        $this->deleteFiles($disk, $orphanFiles);
        $this->info("Se eliminaron " . count($orphanFiles) . " archivos huerfanos en el disco {$disk}");
                }
    }

    private function getRegisteredFiles($disk)
    {
        return ArchivoMovimiento::where('disk', $disk)->get()->map(function($archivo){
            return $archivo->path . $archivo->nombre_guardado;
        })->toArray();
    }
    private function deleteFiles($disk, $files)
    {
        foreach($files as $file){
            Storage::disk($disk)->delete($file);
            $this->line("Archivo eliminado: {$file}");
        }
    }
}
