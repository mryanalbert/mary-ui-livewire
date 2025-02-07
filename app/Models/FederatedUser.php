<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class FederatedUser extends Authenticatable
{
    protected $table = "usr_federated";
    protected $primaryKey = "userId";
}
