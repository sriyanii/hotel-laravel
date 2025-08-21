<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\ActivityLog;

class ResepsionisProfileController extends Controller
{
    // Tampilkan profil resepsionis
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

    // Form edit profil
    public function edit()
    {
        try {
            $user = auth()->user();
            $this->logActivity('Mengakses form edit profil resepsionis', $user);
            return view('resepsionis.profile.edit', compact('user'));
        } catch (\Exception $e) {
            Log::error('Error accessing edit profile form (resepsionis): ' . $e->getMessage());
            return back()->with('error', 'Gagal mengakses form edit profil.');
        }
    }

    // Update profil
    public function update(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . auth()->id(),
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            $user = auth()->user();
            $oldData = $user->toArray();
            $data = $request->only('name', 'email');

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            // Catat perubahan
            $changes = [];
            foreach ($data as $key => $value) {
                if ($oldData[$key] != $value) {
                    $changes[$key] = [
                        'old' => $key === 'password' ? '********' : $oldData[$key],
                        'new' => $key === 'password' ? '********' : $value
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

    // Form ganti password
    public function showChangePasswordForm()
    {
        try {
            $this->logActivity('Mengakses form ganti password (resepsionis)', auth()->user());
            return view('resepsionis.profile.change_password');
        } catch (\Exception $e) {
            Log::error('Error accessing change password form (resepsionis): ' . $e->getMessage());
            return back()->with('error', 'Gagal mengakses form ganti password.');
        }
    }

    // Proses ganti password
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
                    'Gagal ganti password resepsionis: password saat ini salah',
                    $user,
                    'error'
                );
                return back()->withErrors(['current_password' => 'Password saat ini salah.']);
            }

            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            $this->logActivity(
                'Berhasil mengubah password resepsionis',
                $user,
                'security'
            );

            return redirect()->route('resepsionis.profile.show')
                ->with('success', 'Password berhasil diubah.');

        } catch (\Exception $e) {
            Log::error('Error changing password (resepsionis): ' . $e->getMessage());
            $this->logActivity(
                'Gagal mengubah password resepsionis: ' . $e->getMessage(),
                auth()->user(),
                'error'
            );
            return back()->with('error', 'Gagal mengubah password.');
        }
    }

    /**
     * Helper method untuk log aktivitas resepsionis
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
            Log::error('Failed to log activity (resepsionis): ' . $e->getMessage());
        }
    }
}
