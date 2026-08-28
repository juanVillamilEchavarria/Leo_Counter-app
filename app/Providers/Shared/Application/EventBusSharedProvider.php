<?php

namespace App\Providers\Shared\Application;

use App\Infrastructure\Reporte\EventHandlers\Laravel\LaravelInvalidateReportCacheWhenAssociatedDomainIsWritten;
use App\Shared\Application\Events\InvalidateReportCacheActionOcurred;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class EventBusSharedProvider extends ServiceProvider
{
    public function boot(){
        Event::listen(InvalidateReportCacheActionOcurred::class, LaravelInvalidateReportCacheWhenAssociatedDomainIsWritten::class);
    }

}
