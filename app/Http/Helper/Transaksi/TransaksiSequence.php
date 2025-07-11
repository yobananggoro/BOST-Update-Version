<?php

namespace App\Http\Helper\Transaksi;

use Illuminate\Support\Facades\Cache;
use App\Entities\TransactionSeq;
use Ramsey\Uuid\Uuid;
use Exception;

class TransaksiSequence
{
    public static function increaseCounter()
    {
        try {
            $user = auth()->user();
            if (!$user) return false;
            $username = $user->username;

            $trx = TransactionSeq::where('userid', $username)->first();
            if ($trx) {
                $trx->sequence = $trx->sequence == 999999 ? 0 : $trx->sequence + 1;
            } else {
                $trx = new TransactionSeq;
                $trx->id = Uuid::uuid4();
                $trx->userid = $username;
                $trx->sequence = 1;
            }
            $trx->save();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function generateReff()
    {
        $user = auth()->user();
        if (!$user) return null;
        $username = $user->username;
        $branch = optional($user->profile)->unit_kerja_kode ?? '';
        if (preg_match('/[a-zA-Z]/', $branch)) {
            $branch = '0000';
        }

        $trx = TransactionSeq::where('userid', $username)->first();
        $seq = $trx ? $trx->sequence : 1;
        $seq = $seq == 999999 ? 1 : $seq;
        $reff = $branch . $username . 'B' . sprintf('%06d', $seq);
        return $reff;
    }
}
