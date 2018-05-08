<?php

namespace App\Models\Finance;

use App\Models\ProjectStageBilling;
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

    /**
     * Get paginated invoices in the selected date range
     *
     * @param  string $startDate
     * @param  string $endDate
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function filterByDates($start, $end, $paginated = false)
    {
        $invoices = self::whereDate('sent_on', '>=', $start)
            ->whereDate('sent_on', '<=', $end)
            ->orderBy('sent_on', 'desc');

        return $paginated ? $invoices->paginate(config('constants.pagination_size')) : $invoices->get();
    }

    public static function filterByDatesReceived($start, $end)
    {
        return self::whereDate('paid_on', '>=', $start)
            ->whereDate('paid_on', '<=', $end)
            ->orderBy('paid_on', 'desc')
            ->get();
    }
}
