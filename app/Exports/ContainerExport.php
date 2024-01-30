<?php
namespace App\Exports;

use App\Models\ContainerExp as DBContainer;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;

class ContainerExport implements FromCollection
{


    public function query()
    {
        return DBContainer::query()->select('NoJob', 'NOCONTAINER', 'status_bc', 'SIZE', 'WEIGHT', 'CTR_STATUS', 'KD_DOKUMEN', 'NO_PKBE', 'TGL_PKBE', 'NOPOL_MASUK', 'TGLMASUK', 'JAMMASUK', 'NOPOL_KELUAR', 'TGLKELUAR', 'JAMKELUAR', 'UID');
    }
}
