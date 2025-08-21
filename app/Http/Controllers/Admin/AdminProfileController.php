<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\ActivityLog;

class AdminProfileController extends Controller
{
    // Tampilkan profil admin
    public function show()
    {
        try {
            $user = auth()->user();
            $this->logActivity('Melihat profil admin', $user);
            return view('admin.profile.show', compact('user'));
        } catch (\Exception $e) {
            Log::error('Error viewing admin profile: ' . $e->getMessage());
            return back()->with('error', 'Gagal menampilkan profil admin.');
        }
    }

    // Form edit profil
    public function edit()
    {
        try {
            $user = auth()->user();
            $this->logActivity('Mengakses form edit profil admin', $user);
            return view('admin.profile.edit', compact('user'));
        } catch (\Exception $e) {
            Log::error('Error accessing edit profile form: ' . $e->getMessage());
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
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            $user = auth()->user();
            $oldData = $user->toArray();
            $data = $request->only('name', 'email', 'phone', 'address');

            // Upload foto jika ada
            if ($request->hasFile('photo')) {
                // Hapus foto lama jika ada
                if ($user->photo && Storage::exists('public/' . $user->photo)) {
                    Storage::delete('public/' . $user->photo);
                }
                $data['photo'] = $request->file('photo')->store('profile_photos', 'public');
            }

            // Update password jika diisi
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
                // Opsional: simpan plain text password (TIDAK DISARANKAN, tapi jika harus)
                // $data['password_plain'] = $request->password; // Hati-hati! Risiko keamanan
            }

            $user->update($data);

            // Log perubahan
            $changes = [];
            foreach ($data as $key => $value) {
                if ($oldData[$key] != $value) {
                    $changes[$key] = [
                        'old' => in_array($key, ['password', 'password_plain', 'photo']) ? '********' : $oldData[$key],
                        'new' => in_array($key, ['password', 'password_plain', 'photo']) ? '********' : $value
                    ];
                }
            }

            if (!empty($changes)) {
                $this->logActivity(
                    'Memperbarui profil admin: ' . json_encode($changes),
                    $user,
                    'update'
                );
            }

            return redirect()->route('admin.profile.show')
                ->with('success', 'Profil admin berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Error updating admin profile: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui profil admin.');
        }
    }

    // Form ganti password
    public function showChangePasswordForm()
    {
        try {
            $this->logActivity('Mengakses form ganti password', auth()->user());
            return view('admin.profile.change_password');
        } catch (\Exception $e) {
            Log::error('Error accessing change password form: ' . $e->getMessage());
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
                    'Gagal ganti password: password saat ini salah',
                    $user,
                    'error'
                );
                return back()->withErrors(['current_password' => 'Password saat ini salah.']);
            }

            // Update password
            $data = ['password' => Hash::make($request->new_password)];
            // Opsional: simpan password plain (TIDAK AMAN!)
            // $data['password_plain'] = $request->new_password;

            $user->update($data);

            // Update waktu perubahan password
            // Jika Anda menambahkan kolom `password_changed_at`
            // $user->update(['password_changed_at' => now()]);

            $this->logActivity(
                'Berhasil mengubah password',
                $user,
                'security'
            );

            return redirect()->route('admin.profile.show')
                ->with('success', 'Password berhasil diubah.');

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
                'data' => $type === 'error' ? null : json_encode(request()->except(['password', 'current_password', 'new_password', '_token']))
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log activity: ' . $e->getMessage());
        }
    }
}