<?php

namespace App\Policies;

use App\Models\Laporan;
use App\Models\User;

class LaporanPolicy
{
    public function view(User $user, Laporan $laporan)
    {
        return $user->id === $laporan->user_id;
    }

    public function update(User $user, Laporan $laporan)
    {
        return $user->id === $laporan->user_id && $laporan->status === 'Belum Diproses';
    }

    public function delete(User $user, Laporan $laporan)
    {
        return $user->id === $laporan->user_id && $laporan->status === 'Belum Diproses';
    }
}
