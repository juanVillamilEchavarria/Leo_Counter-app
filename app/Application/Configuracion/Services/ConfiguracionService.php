<?php
// Archivo obsoleto tras separar el listado de soft deletes hacia QueryBus + estrategias. Conservado comentado por trazabilidad.
// 
// namespace App\Application\Configuracion\Services;
// 
// use App\Domains\Configuracion\Services\ConfiguracionDeletedDomainService;
// use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
// use App\Domains\Configuracion\Exceptions\InvalidDomainType;
// class ConfiguracionService{
//     public function __construct(
//         private ConfiguracionDeletedDomainService $configuracionDeletedDomainService
//     )
//     {
//     }
// 
//     public function getAllDeleted(string $domain){
//         
//         return $this->configuracionDeletedDomainService->getAllDeleted($this->resolveSoftDeleteManagerType($domain));
//     }
// 
//     public function restore(int $id, string $domain){
//         return $this->configuracionDeletedDomainService->restore($id, $this->resolveSoftDeleteManagerType($domain));
//     }
// 
//     public function hardDelete(int $id, string $domain){
//         return $this->configuracionDeletedDomainService->hardDelete($id, $this->resolveSoftDeleteManagerType($domain));
//     }
// 
//     public function resolveSoftDeleteManagerType(string $domain): SoftDeleteManagerTypes{
//        try {
//           return SoftDeleteManagerTypes::from($domain);
//        } catch (\Throwable $th) {
//        
//            throw new InvalidDomainType('Dominio invalido: '.$th->getMessage());
//        }
//     }
// }
