<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Support\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * @mixin Builder
 * @mixin QueryBuilder
 */
trait HelperTraits
{
    use HasFactory;
    use NewInstance;
    use SerializeDate;
    use Sanitize;
    use QueryLister;
    use UniqueRule;
}
