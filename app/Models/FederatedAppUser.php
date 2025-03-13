<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FederatedAppUser extends Model
{
    protected $table = 'appusr_federated';
    protected $primaryKey = 'appusrId';
}
