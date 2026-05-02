<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HRJobVacancyController extends Controller
{
    /**
     * Helper: Base query — Admin sees all, HR sees only their own.
     */
    private function baseQuery()
    {
        $user = Auth::user();
        return $user->role === 'admin'
            ? JobVacancy::query()
            : JobVacancy::where('created_by', $user->id);
    }

    /**
     * Tampilkan semua lowongan.
     */
    public function index(Request $request)
    {
        $vacancies = $this->baseQuery()
            ->withCount('applications')
            ->when($request->search, function ($q, $search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%");
            })
            ->when($request->status, fn($q, $v) => $q->where('status', $v))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pages.hr.vacancies.index', compact('vacancies'));
    }

    /**
     * Form tambah lowongan baru.
     */
    public function create()
    {
        return view('pages.hr.vacancies.create');
    }

    /**
     * Simpan lowongan baru dengan validasi lengkap.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'department'   => 'required|string|max:255',
            'description'  => 'required|string',
            'requirements' => 'required|string',
            'division'     => 'required|string|max:255',
            'type'         => 'required|in:full-time,part-time,contract',
            'deadline'     => 'required|date|after:today',
        ], [
            'title.required'        => 'Judul lowongan wajib diisi.',
            'department.required'   => 'Departemen wajib diisi.',
            'description.required'  => 'Deskripsi wajib diisi.',
            'requirements.required' => 'Persyaratan wajib diisi.',
            'division.required'     => 'Divisi wajib diisi.',
            'type.required'         => 'Tipe pekerjaan wajib dipilih.',
            'type.in'               => 'Tipe pekerjaan tidak valid.',
            'deadline.required'     => 'Deadline wajib diisi.',
            'deadline.after'        => 'Deadline harus setelah hari ini.',
        ]);

        // Set default status open dan catat HR pembuat
        $validated['status']     = 'open';
        $validated['created_by'] = Auth::id();

        JobVacancy::create($validated);

        return redirect()
            ->route('hr.vacancies.index')
            ->with('success', 'Lowongan berhasil ditambahkan.');
    }

    /**
     * Form edit lowongan.
     */
    public function edit(string $id)
    {
        $vacancy = $this->baseQuery()->findOrFail($id);

        return view('pages.hr.vacancies.edit', compact('vacancy'));
    }

    /**
     * Tampilkan detail lowongan.
     */
    public function show(string $id)
    {
        $vacancy = $this->baseQuery()
            ->withCount('applications')
            ->findOrFail($id);

        return view('pages.hr.vacancies.show', compact('vacancy'));
    }

    /**
     * Update lowongan dengan validasi.
     */
    public function update(Request $request, string $id)
    {
        $vacancy = $this->baseQuery()->findOrFail($id);

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'department'   => 'required|string|max:255',
            'description'  => 'required|string',
            'requirements' => 'required|string',
            'division'     => 'required|string|max:255',
            'type'         => 'required|in:full-time,part-time,contract',
            'deadline'     => 'required|date|after:today',
        ], [
            'title.required'        => 'Judul lowongan wajib diisi.',
            'department.required'   => 'Departemen wajib diisi.',
            'description.required'  => 'Deskripsi wajib diisi.',
            'requirements.required' => 'Persyaratan wajib diisi.',
            'division.required'     => 'Divisi wajib diisi.',
            'type.required'         => 'Tipe pekerjaan wajib dipilih.',
            'type.in'               => 'Tipe pekerjaan tidak valid.',
            'deadline.required'     => 'Deadline wajib diisi.',
            'deadline.after'        => 'Deadline harus setelah hari ini.',
        ]);

        $vacancy->update($validated);

        return redirect()
            ->route('hr.vacancies.index')
            ->with('success', 'Lowongan berhasil diperbarui.');
    }

    /**
     * Hapus lowongan (soft delete).
     */
    public function destroy(string $id)
    {
        $vacancy = $this->baseQuery()->findOrFail($id);
        $vacancy->delete(); // soft delete karena model pakai SoftDeletes

        return redirect()
            ->route('hr.vacancies.index')
            ->with('success', 'Lowongan berhasil dihapus.');
    }

    /**
     * Toggle status lowongan: open ↔ closed.
     */
    public function toggleStatus(string $id)
    {
        $vacancy = $this->baseQuery()->findOrFail($id);

        $vacancy->update([
            'status' => $vacancy->isOpen() ? 'closed' : 'open',
        ]);

        $label = $vacancy->isOpen() ? 'dibuka' : 'ditutup';

        return redirect()
            ->back()
            ->with('success', "Lowongan berhasil {$label}.");
    }
}
