<?php

namespace App\Exports\FixedAssetSchedule;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class BranchWise implements FromView
{
    protected $particulars;
    protected $extra;
    protected $search_by;
    protected $roles;

    public function __construct($branch_wise)
    {
        $this->particulars=$branch_wise['particulars'];
        $this->extra=$branch_wise['extra'];
        $this->search_by=$branch_wise['search_by'];
    }
    public function view(): View
    {
        return view('admin.accounts-report.fixed-asset-schedule.branch-wise.exl', [
            'particulars' => $this->particulars,
            'extra' => $this->extra,
            'search_by' => $this->search_by,
        ]);
    }



}
