<?php

namespace Tests\Unit;

use App\Models\Anggota;
use PHPUnit\Framework\TestCase;

class AnggotaStatusTest extends TestCase
{
    public function test_anggota_terverifikasi_aktif_dapat_mengakses_layanan(): void
    {
        $anggota = new Anggota([
            'status_anggota' => Anggota::STATUS_AKTIF,
            'verifikasi_admin' => Anggota::VERIFIKASI_TERVERIFIKASI,
        ]);

        $this->assertTrue($anggota->dapatMengaksesLayanan());
    }

    public function test_anggota_menunggu_tidak_dapat_mengakses_layanan(): void
    {
        $anggota = new Anggota([
            'status_anggota' => Anggota::STATUS_TIDAK_AKTIF,
            'verifikasi_admin' => Anggota::VERIFIKASI_MENUNGGU,
        ]);

        $this->assertFalse($anggota->dapatMengaksesLayanan());
        $this->assertSame(
            'Akun anggota sedang menunggu verifikasi admin.',
            $anggota->pesanAksesDitolak()
        );
    }

    public function test_anggota_ditolak_tidak_dapat_mengakses_layanan(): void
    {
        $anggota = new Anggota([
            'status_anggota' => Anggota::STATUS_TIDAK_AKTIF,
            'verifikasi_admin' => Anggota::VERIFIKASI_DITOLAK,
        ]);

        $this->assertFalse($anggota->dapatMengaksesLayanan());
        $this->assertSame(
            'Akun anggota ditolak oleh admin dan statusnya tidak aktif.',
            $anggota->pesanAksesDitolak()
        );
    }
}
