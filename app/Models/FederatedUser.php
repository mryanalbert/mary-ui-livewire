<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class FederatedUser extends Authenticatable
{
    protected $table = "usr_federated";
    protected $primaryKey = "userId";

    protected $hidden = [
        'userPassword',
        'reset_token_hash'
    ];

    // Define the many-to-many relationship with AppFederated
    public function apps()
    {
        // return $this->belongsToMany(FederatedApp::class, 'appusr_federated', 'userId', 'appId')
        //     ->withPivot('gUserName', 'isActive', 'priviledgeCode', 'dtCreated'); // You can use pivot data if needed
        return $this->belongsToMany(FederatedApp::class, 'appusr_federated', 'userId', 'appId');
    }
}
