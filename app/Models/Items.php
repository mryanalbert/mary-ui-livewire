<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Items extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'item_id';

    protected $fillable = [
        'item_name',
        'item_pr',
        'item_qty',
        'item_unit_id',
        'item_priority',
        'item_attachment',
        'item_note',
        'item_status_id',
        'item_created_by',
        'item_requestor',
        'item_to_be_appr_by',
        'item_log_by',
    ];

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        // Listen for the 'creating' event
        static::creating(function ($item) {
            // Get the current database time (for year, month, day)
            $result = DB::select('SELECT NOW() as `current_db_time`');
            $date = $result[0]->current_db_time; // Access the field with the new name

            // Use Carbon to parse the date
            $year = Carbon::parse($date)->format('y');  // Get last two digits of the year
            $month = Carbon::parse($date)->format('m'); // Get month (two digits)
            $day = Carbon::parse($date)->format('d');   // Get day (two digits)

            // Get the count of items created on the same day (based on the same current date from the DB)
            $count = DB::table('items')
                ->whereDate('item_created_at', Carbon::parse($date)->toDateString()) // Filter by today's date
                ->count();

            // Format the item_pr (e.g., '250313001' for March 13, 2025, and first item)
            $item->item_pr = $year . $month . $day . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
        });
    }
}
