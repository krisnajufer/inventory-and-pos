<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WarehouseRequests extends Model
{
    use HasFactory;

    protected $table = 'warehouse_requests';
    protected $primaryKey = 'warehouse_request_id';
    protected $keyType = 'string';
}
