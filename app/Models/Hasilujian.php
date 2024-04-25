<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\JawabEsay;
use App\Traits\LogTrait;

class Hasilujian extends Model
{
    use LogTrait;

	protected $guarded = [];

	public function mhs($kd_lokal)
	{
		$mhs = DB::table('mhs')->where('kd_lokal', $kd_lokal);
		if ($mhs->count() > 0) {
			foreach ($mhs->get() as $i) {
				$h[$i->nim] = $i->nm_mhs;
			}
			return $h;
		}
	}

	public function nilai($id_soal, $kd_lokal)
	{
		$nilai = DB::table('hasilujians')
			->where('id_soal', $id_soal)
			->where('kd_lokal', $kd_lokal);


		if ($nilai->count() > 0) {
			foreach ($nilai->get() as $i) {
				$h[$i->id_user] = $i;
			}
			return $h;
		} else {
			return $nilai->count();
		}
	}

	public function nilai_essay($id_soal, $kd_lokal)
	{
		$essay = DB::table('jawab_esays')
			->where('id_soal', $id_soal)
			->where('id_kelas', $kd_lokal);


		if ($essay->count() > 0) {
			$h = [];
			foreach ($essay->get() as $i) {
				if (!isset($h[$i->id_user])) {
					$h[$i->id_user] = 0;
				}
				$h[$i->id_user] += $i->score;
			}
			return $h;
		} else {
			return null;
		}
	}

	public function nilai_pg($id_soal, $kd_lokal)
	{
		$pg = DB::table('jawabs')
			->where('id_soal', $id_soal)
			->where('id_kelas', $kd_lokal);


		if ($pg->count() > 0) {
			$h = [];
			foreach ($pg->get() as $i) {
				if (!isset($h[$i->id_user])) {
					$h[$i->id_user] = 0;
				}
				$h[$i->id_user] += $i->score;
			}
			return $h;
		} else {
			return null;
		}
	}

	public function soals()
	{
		$pakets = DB::table('distribusisoals')
			->join('soals', 'distribusisoals.id_soal', 'soals.id')
			->join('mtk', 'soals.kd_mtk', 'mtk.kd_mtk')
			->select(
				'distribusisoals.*',
				'mtk.nm_mtk',
				'soals.paket',
				'soals.kd_mtk',
				'soals.tgl_ujian',
				'soals.kd_dosen',
				'soals.waktu',
				'soals.id as ids',
				'soals.tgl_selsai_ujian'
			)
			->where('distribusisoals.id_kelas', auth()->user()->kode)
			->where('paket', 'LATIHAN');
		if ($pakets->count() > 0) {
			foreach ($pakets->get() as $i) {
				$h[$i->id_soal] = $i;
			}
			return $h;
		}
	}

	public function hasil_ujian()
	{
		$hasil = DB::table('hasilujians')
			->where('kd_lokal', auth()->user()->kode)
			->where('id_user', auth()->user()->username);


		if ($hasil->count() > 0) {
			foreach ($hasil->get() as $i) {
				$h[$i->id_soal] = $i;
			}
			return $h;
		} else {
			return $hasil->get();
		}
	}
}
