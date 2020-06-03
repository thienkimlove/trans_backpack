<?php
/**
 * Created by PhpStorm.
 * User: tieungao
 * Date: 2020-06-03
 * Time: 10:15
 */

namespace App;


use App\Models\Card;
use App\Models\Machine;
use App\Models\Record;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Helpers
{
    public static function log($msg)
        {
        if (is_array($msg)) {
            $message = json_encode($msg, true);
        } else {
            $message = $msg;
        }
        @file_put_contents(storage_path('logs/debug.log'), $message . "\n", FILE_APPEND);
    }


    public static function getRevertedDates()
    {
        $ars = [];

        for ($i=1; $i < 32; $i++) {
            $ars[$i] = 'Ngày '.$i;
        }

        return $ars;
    }

    public static function setRequestAmount($amountStr)
    {
        if ($amountStr) {
            $amountStr = str_replace('.', '', $amountStr);
        } else {
            $amountStr = 0;
        }
        return $amountStr;
    }

    public static function checkCanCreateTransactionCard($entry)
    {
        return true;
    }

    public static function getCurrentAvailableAmount($machine)
    {
        $todayTransactions = Record::where('machine_id', $machine)
            ->whereDate('created_at', Carbon::now()->toDateString())
            ->sum('amount');

        return ($todayTransactions < $machine->max_amount_per_date) ? $machine->max_amount_per_date - $todayTransactions : 0;
    }

    public static function createTransactionCard($data)
    {
        $card = Card::find($data['crud_id']);

        if (!$card) {
            return [false, 'Không tìm thấy card tương ứng'];
        }

        if (isset($data['amount_put'])) {
            $amountPut = self::setRequestAmount($data['amount_put']);

            Record::create([
                'card_id' => $card->id,
                'amount' => $amountPut,
                'card_fee_percent' => $card->trans_fee_percent
            ]);

        }

        if (isset($data['amount_get'])) {
            // find machine.
            $listMachines = [];
            $amountGet = self::setRequestAmount($data['amount_get']);
            $machines = Machine::all();

            foreach ($machines as $machine) {
                $currentAvailableAmount = self::getCurrentAvailableAmount($machine);

                // thanh toan kha dung va con tien trong may'
                if (in_array($card->bank_id, $machine->availableBanks->pluck('id')->all()) && $currentAvailableAmount > 0) {
                    $listMachines[] = [
                        'availAmount' => $currentAvailableAmount,
                        'machine' => $machine
                    ];
                }
            }

            if (count($listMachines) == 0) {
                return [false, 'Không có máy POS nào thỏa mãn điều kiện'];
            }

            usort($listMachines, function($a, $b) {
                return $a['availAmount'] > $b['availAmount'];
            });

            DB::beginTransaction();

            try {
                foreach ($listMachines as $listMachine) {
                    // amount can trans for POS.

                   if ($amountGet > 0) {
                       $amountCanPOS = ($listMachine['availAmount'] > $listMachine['machine']->max_amount_per_trans)? $listMachine['machine']->max_amount_per_trans : $listMachine['availAmount'];

                       // kiem tra xem trong hom nay POS nay da quet cho the nay 2 lan chua.

                       $currentPOSTimeToday = Record::where('machine_id', $listMachine['machine']->id)
                           ->whereDate('created_at', Carbon::now()->toDateString())
                           ->count();

                       if ($currentPOSTimeToday < 2) {
                           // quet
                           $amountGetThisPOS = ($amountGet >= $amountCanPOS)? $amountCanPOS : $amountGet;

                           Record::create([
                               'card_id' => $card->id,
                               'machine_id' => $listMachine['machine']->id,
                               'amount' => $amountGetThisPOS,
                               'card_fee_percent' => $card->trans_fee_percent,
                               'machine_fee_percent' => $listMachine['machine']->fee_percent_per_trans,
                           ]);

                           $amountGet = ($amountGet >= $amountCanPOS)? $amountGet - $amountCanPOS : 0;
                       }
                   }

                }

                if ($amountGet > 0) {
                    throw new \Exception('Không quẹt được hết số tiền');
                }
                DB::commit();
                return [true, 'Thực hiện thành công'];
            } catch (\Exception $exception) {
                DB::rollBack();
                return [false, $exception->getMessage()];
            }
        }


        return [true, 'Success'];
    }

}