<?php


namespace App\Repositories\Reports;

use App\Repositories\Reports\ReportsRepositoryInterface;
use App\Models\Subsidiary;

class ReportsRepositories implements ReportsRepositoryInterface
{

    protected $subsidiary;


    public function __construct(Subsidiary $subsidiary)
    {
        $this->subsidiary = $subsidiary;
    }
    public function getAllReports()
    {
        $cashtransaction_blotter = Subsidiary::all();

        return $cashtransaction_blotter;
    }
}
