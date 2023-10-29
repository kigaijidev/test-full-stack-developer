use App\Models\Backend\MstOrder;
use App\Models\Backend\Log;

class ProcessOrderCustomer
{
    /**
    * Process Order
    * @param string $fromDate
    * @param string $toDate
    * @param float $maxProfitRateNew
    * @return void
    */
    public function processOrder($fromDate, $toDate, $maxProfitRateNew) {
        $modelOrder = new MstOrder;

        // return 100.000 record
        $dataOrder = $modelOrder->getOrder($fromDate, $toDate);

        foreach ($dataOrder as $order) {
            $modelLog = new Log; 
            $priceInvoice = $order->price_invoice;
            $maxProfitRateOld = $order->max_profit_rate;

            if ($maxProfitRateNew != $maxProfitRateOld) {
                // Sử dụng bất đồng bộ để thực hiện thao tác trong nền
                async(function () use ($order, $maxProfitRateNew, $priceInvoice, $modelOrder, $modelLog) {
                    $maxProfitPrice = $priceInvoice / (1 - $maxProfitRateNew);

                    try {
                        // Update the order and log the change
                        $modelOrder->updateOrder($order, $maxProfitPrice);
                        $modelLog->insertLog($order, $maxProfitPrice);
                    } catch (\Exception $e) {
                        // Handle exceptions here
                        // Log or report the error
                    }
                });
            }
        }
    }
}
