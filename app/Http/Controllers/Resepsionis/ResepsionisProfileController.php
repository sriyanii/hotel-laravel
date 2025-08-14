<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\ActivityLog;

class ResepsionisProfileController extends Controller
{
    public function show()
    {
        try {
            $user = auth()->user();
            $this->logActivity('Melihat profil resepsionis', $user);
            return view('resepsionis.profile.show', compact('user'));
        } catch (\Exception $e) {
            Log::error('Error viewing resepsionis profile: ' . $e->getMessage());
            return back()->with('error', 'Gagal menampilkan profil resepsionis.');
        }
    }

    public function edit()
    {
        try {
            $user = auth()->user();
            $this->logActivity('Mengakses form edit profil resepsionis', $user);
            return view('resepsionis.profile.edit', compact('user'));
        } catch (\Exception $e) {
            Log::error('Error accessing edit profile form: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengakses form edit profil.');
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . auth()->id(),
            ]);

            $user = auth()->user();
            $oldData = $user->only('name', 'email');
            $newData = $request->only('name', 'email');

            $user->update($newData);

            // Log changes
            $changes = [];
            foreach ($newData as $key => $value) {
                if ($oldData[$key] != $value) {
                    $changes[$key] = [
                        'old' => $oldData[$key],
                        'new' => $value
                    ];
                }
            }

            if (!empty($changes)) {
                $this->logActivity(
                    'Memperbarui profil resepsionis: ' . json_encode($changes),
                    $user,
                    'update'
                );
            }

            return redirect()->route('resepsionis.profile.show')
                ->with('success', 'Profil resepsionis berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Error updating resepsionis profile: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui profil resepsionis.');
        }
    }

    public function showChangePasswordForm()
    {
        try {
            $user = auth()->user();
            $this->logActivity('Mengakses form ganti password resepsionis', $user);
            return view('resepsionis.profile.change_password', compact('user'));
        } catch (\Exception $e) {
            Log::error('Error accessing password change form: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengakses form ganti password.');
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
            ]);

            $user = auth()->user();

            if (!Hash::check($request->current_password, $user->password)) {
                $this->logActivity(
                    'Gagal ganti password: password saat ini salah',
                    $user,
                    'security'
                );
                return back()->withErrors(['current_password' => 'Password saat ini salah.']);
            }

            $user->update(['password' => Hash::make($request->new_password)]);

            $this->logActivity(
                'Berhasil mengubah password resepsionis',
                $user,
                'security'
            );

            return redirect()->route('resepsionis.profile.show')
                ->with('success', 'Password resepsionis berhasil diubah.');

        } catch (\Exception $e) {
            Log::error('Error changing password: ' . $e->getMessage());
            $this->logActivity(
                'Gagal mengubah password: ' . $e->getMessage(),
                auth()->user(),
                'error'
            );
            return back()->with('error', 'Gagal mengubah password.');
        }
    }

    /**
     * Helper method to log activities
     *
     * @param string $description
     * @param \App\Models\User $user
     * @param string $type
     */
    private function logActivity(string $description, $user, string $type = 'info')
    {
        try {
            ActivityLog::create([
                'user_id' => $user->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'description' => $description,
                'type' => $type,
                'method' => request()->method(),
                'url' => request()->fullUrl(),
                'referer' => request()->header('referer'),
                'data' => $type === 'error' ? null : json_encode(request()->except(['password', '_token']))
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log activity: ' . $e->getMessage());
        }
    }
}