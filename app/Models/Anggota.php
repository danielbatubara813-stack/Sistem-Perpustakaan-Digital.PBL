<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Anggota extends Authenticatable implements CanResetPasswordContract
{
    use Notifiable;
    use CanResetPassword;
    public const STATUS_AKTIF = 'Aktif';

    public const STATUS_TIDAK_AKTIF = 'Tidak Aktif';

    public const VERIFIKASI_MENUNGGU = 'Menunggu';

    public const VERIFIKASI_TERVERIFIKASI = 'Terverifikasi';

    public const VERIFIKASI_DITOLAK = 'Ditolak';

    protected $table = 'anggota';

    protected $primaryKey = 'id_anggota';

    public $timestamps = false;

    protected $fillable = [
        'id_jenis',
        'nomor_identitas',
        'jenis_nomor_identitas',
        'email',
        'nama',
        'no_hp',
        'status_anggota',
        'jenis_kelamin',
        'tanggal_lahir',
        'profile',
        'tanggal_daftar',
        'verifikasi_admin',
        'foto_ktp',
        'tanggal_diubah',
        'password',
    ];

    public function getFotoProfileUrlAttribute()
    {
        if ($this->profile) {
            return asset('storage/' . $this->profile);
        }

        return asset('images/default-avatar.svg');
    }

    protected $hidden = ['password'];

    public function dapatMengaksesLayanan(): bool
    {
        return $this->status_anggota === self::STATUS_AKTIF
            && $this->verifikasi_admin === self::VERIFIKASI_TERVERIFIKASI;
    }

    public function pesanAksesDitolak(): string
    {
        if ($this->verifikasi_admin === self::VERIFIKASI_MENUNGGU) {
            return 'Akun anggota sedang menunggu verifikasi admin.';
        }

        if ($this->verifikasi_admin === self::VERIFIKASI_DITOLAK) {
            return 'Akun anggota ditolak oleh admin dan statusnya tidak aktif.';
        }

        if ($this->status_anggota !== self::STATUS_AKTIF) {
            return 'Akun anggota tidak aktif.';
        }

        return 'Akun anggota belum dapat mengakses layanan.';
    }

    public function jenisKeanggotaan()
    {
        return $this->belongsTo(
            JenisKeanggotaan::class,
            'id_jenis',
            'id_jenis'
        );
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_anggota', 'id_anggota');
    }
}
