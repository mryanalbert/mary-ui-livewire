<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FederatedApp extends Model
{
    protected $table = 'app_federated';
    protected $primaryKey = 'appId';

    // Define the many-to-many relationship with UsrFederated
    public function users()
    {
        return $this->belongsToMany(FederatedUser::class, 'appusr_federated', 'appId', 'userId'); // Pivot data for app-user relationship
        // return $this->belongsToMany(FederatedUser::class, 'appusr_federated', 'appId', 'userId')
        //     ->withPivot('gUserName', 'isActive', 'priviledgeCode', 'dtCreated'); // Pivot data for app-user relationship
    }
}
