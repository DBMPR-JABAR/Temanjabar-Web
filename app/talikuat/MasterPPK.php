<?php

namespace App\talikuat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPPK extends Model
{
    use HasFactory;
    protected $connection= 'talikuat';
    protected $table = 'user_details';
    protected $guarded = [];

    public function ppk($excludeDeleted = true) {
        return parent::ppk($excludeDeleted)
            ->where('rule_user_id', '=', 2);
    }
}
