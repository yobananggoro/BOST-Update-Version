<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDashboardFunctions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE FUNCTION chart_pembukaan_rekening(\"pPeriode\" date, \"pKode\" varchar)
  RETURNS TABLE(\"tanggal\" date, \"pending\" int8, \"sukses\" int8, \"gagal\" int8) AS $$
DECLARE 
	dAwal DATE; dAkhir DATE;
	
BEGIN

	SELECT DATE_TRUNC('month', \"pPeriode\")::DATE, (DATE_TRUNC('month', \"pPeriode\") + interval '1 month - 1 day')::DATE 
	INTO dAwal, dAkhir;

	LOOP EXIT WHEN dAwal > dAkhir;
		IF \"pKode\" = '' THEN
			RETURN QUERY SELECT dAwal, 
        (SELECT COUNT(*) FROM rdn_nasabah WHERE status IN (1, 2) AND tgl_request::DATE = dAwal),
        (SELECT COUNT(*) FROM rdn_nasabah WHERE status IN (3, 4) AND tgl_request::DATE = dAwal),
        (SELECT COUNT(*) FROM rdn_nasabah WHERE status IN (7, 8, 9) AND tgl_request::DATE = dAwal);
		ELSE
			RETURN QUERY SELECT dAwal, 
        (SELECT COUNT(*) FROM rdn_nasabah WHERE status IN (1, 2) AND tgl_request::DATE = dAwal AND unit_kerja_kode = \"pKode\"),
        (SELECT COUNT(*) FROM rdn_nasabah WHERE status IN (3, 4) AND tgl_request::DATE = dAwal AND unit_kerja_kode = \"pKode\"),
        (SELECT COUNT(*) FROM rdn_nasabah WHERE status IN (7, 8, 9) AND tgl_request::DATE = dAwal AND unit_kerja_kode = \"pKode\");
		END IF;
		dAwal := (dAwal + interval '1 day')::DATE;
	END LOOP;

END;
$$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 
    }
}
