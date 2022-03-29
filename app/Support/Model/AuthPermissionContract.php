<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Support\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface AuthPermissionContract
{
    /**
     * @return BelongsTo
     */
    public function permission(): BelongsTo;
}
