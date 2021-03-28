<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    const STATUS_PENDING = 0;
    const STATUS_COMPLETED = 1;
    const STATUS_FAILED = 2;

    const CATEGORY_ACCOUNT = 'account';
    const CATEGORY_AMOCRM = 'amocrm';

    /**
     * @var string
     */
    protected $table = 'tasks';

    /**
     * @var array
     */
    protected $fillable = ['category', 'task', 'data', 'error_code', 'status'];

    /**
     * @var array
     */
    protected $casts = [
        'data' => 'json',
    ];
}
