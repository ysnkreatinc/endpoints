<?php

namespace Kreatinc\Bot\Models\Filters;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class SubscribersFilters extends QueryFilters
{
    /**
     * Filter subscribers by full name.
     *
     * @param  string  $name
     * @return Builder
     */
    public function name($name)
    {
        return $this->builder->orWhere(DB::raw('concat(first_name," ",last_name)') , 'LIKE' , "%{$name}%", 'or');
    }

    /**
     * Filter subscribers by first name.
     *
     * @param  string  $name
     * @return Builder
     */
    public function first_name($name)
    {
        return $this->builder->orWhere('first_name', 'LIKE', "%{$name}%");
    }

    /**
     * Filter subscribers by last name.
     *
     * @param  string  $name
     * @return Builder
     */
    public function last_name($name)
    {
        return $this->builder->orWhere('last_name', 'LIKE', "%{$name}%");
    }

    /**
     * Filter subscribers by email.
     *
     * @param  string  $email
     * @return Builder
     */
    public function email($email)
    {
        return $this->builder->orWhere('email', 'LIKE', "%{$email}%");
    }
}
