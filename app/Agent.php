<?php

namespace Mulu;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    //
    /**
     * @return array
     */
    public function saveAgent($name,$zip_code,$coordinates)
    {
        $this->name=$name;
        $this->zip_code=$zip_code;
        $this->coordinates=$coordinates;
        return $this->save();;
    }

}
