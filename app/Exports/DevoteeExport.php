<?php

namespace App\Exports;

use App\Models\Devotees;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DevoteeExport implements FromView
{
    public function view(): View
    {
        return view('backend.export.devotee', [
            'devotees' => Devotees::all()
        ]);
    }
}
