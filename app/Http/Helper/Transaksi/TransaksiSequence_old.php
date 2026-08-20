<?php

namespace App\Http\Helper\Transaksi;

use Illuminate\Support\Facades\Cache;
use App\Entities\TransactionSeq;
use Ramsey\Uuid\Uuid;
use Exception;

class TransaksiSequence
{
    // public static function increaseCounter()
    // {
    //     try {
    //         $sqnc = TransactionSeq::findsequence();
    //         $userid = auth()->user()->username;
    //         if (count($sqnc) > 0) {
    //             $seq = $sqnc->first();
    //             $trx = TransactionSeq::where('userid', $userid)->first();
    //             $trx->userid = $userid;
    //             $trx->sequence = $seq->sequence + 1;
    //         } else {
    //             $trx = new TransactionSeq;
    //             $trx->id = Uuid::uuid4();
    //             $trx->userid = $userid;
    //             $trx->sequence = 1;
    //         }

    //         $trx->save();
    //         return true;
    //     } catch (Exception $e) {
    //         return false;
    //     }
    // }

    public static function increaseCounter()
    {
        $userid = auth()->user()->username;
        $seq = TransactionSeq::findsequence()->first();
        $trx = TransactionSeq::firstOrNew(['userid' => $userid]);

        if (!$trx->exists) {
            $trx->id = Uuid::uuid4();
        }

        $trx->sequence = $seq ? $seq->sequence + 1 : 1;
        return $trx->save();
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
