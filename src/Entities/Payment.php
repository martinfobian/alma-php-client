<?php
/**
 * Copyright (c) 2018 Alma / Nabla SAS
 *
 * THE MIT LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and
 * to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
 * Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF
 * CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 *
 * @author    Alma / Nabla SAS <contact@getalma.eu>
 * @copyright Copyright (c) 2018 Alma / Nabla SAS
 * @license   https://opensource.org/licenses/MIT The MIT License
 *
 */

namespace Alma\API\Entities;

class Payment extends Base
{
    const STATE_IN_PROGRESS = 'in_progress';
    const STATE_PAID = 'paid';

    const FRAUD_AMOUNT_MISMATCH = 'amount_mismatch';
    const FRAUD_STATE_ERROR = 'state_error';

    /** @var string */
    public $url;
    /** @var string */
    public $state;
    /** @var int */
    public $purchase_amount;
    /** @var Instalment[] */
    public $payment_plan;
    /** @var string */
    public $return_url;
    /** @var array */
    public $custom_data;
    /** @var Order[] */
    public $orders;

    public function __construct($attributes)
    {
        // Manually process `payment_plan` to create Instalment instances
        if (array_key_exists('payment_plan', $attributes)) {
            $this->payment_plan = array();

            foreach ($attributes['payment_plan'] as $instalment) {
                $this->payment_plan[] = new Instalment($instalment);
            }

            unset($attributes['payment_plan']);
        }

        if (array_key_exists('orders', $attributes)) {
            $this->orders = array();

            foreach ($attributes['orders'] as $order) {
                $this->orders[] = new Order($order);
            }

            unset($attributes['orders']);
        }

        parent::__construct($attributes);
    }
}
