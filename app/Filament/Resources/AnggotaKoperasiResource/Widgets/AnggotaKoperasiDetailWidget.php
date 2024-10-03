<?php

namespace App\Filament\Resources\AnggotaKoperasiResource\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class AnggotaKoperasiDetailWidget extends Widget
{
    protected static string $view = 'filament.resources.anggota-koperasi-resource.widgets.anggota-koperasi-detail-widget';
    protected int | string | array $columnSpan = 2; // Full Width
    public ?Model $record = null;
}
