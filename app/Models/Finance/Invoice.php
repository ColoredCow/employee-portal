<?php

namespace App\Models\Finance;

use App\Models\ProjectStageBilling;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'finance_invoices';

    protected $guarded = [];

    /**
     * Get the project_stage_billings associated with the invoice.
     */
    public function projectStageBillings()
    {
        return $this->hasMany(ProjectStageBilling::class, 'finance_invoice_id');
    }

    /**
     * Get details to list invoices
     *
     * @return self
     */
    public static function getList()
    {
    	return self::orderBy('sent_on', 'desc')
            ->paginate(config('constants.pagination_size'));
    }

    public static function getLastMonthInvoices()
    {
        return self::whereDate('sent_on', '>=', new Carbon('first day of last month'))
            ->whereDate('sent_on', '<=', new Carbon('last day of last month'))
            ->orderBy('sent_on', 'desc')
            ->get();
    }
}
