<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;

    // modal state
    public bool $openEdit = false;

    // form fields
    public ?int $editId = null;
    public string $name = '';
    public string $email = '';
    public string $role = 'customer';
    public string $newPassword = '';

    protected function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->editId),
            ],
            'role' => ['required', Rule::in(['admin', 'customer'])],
            'newPassword' => ['nullable', 'string', 'min:6'],
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function openEdit(int $id): void
    {
        $u = User::query()->findOrFail($id);

        $this->editId = $u->id;
        $this->name = $u->name;
        $this->email = $u->email;
        $this->role = $u->role ?? 'customer';
        $this->newPassword = '';

        $this->openEdit = true;
    }

    public function save(): void
    {
        $this->validate();

        $u = User::query()->findOrFail($this->editId);

        $u->name = $this->name;
        $u->email = $this->email;
        $u->role = $this->role;

        if ($this->newPassword !== '') {
            $u->password = Hash::make($this->newPassword);
        }

        $u->save();

        $this->openEdit = false;

        session()->flash('success', 'Customer berhasil diperbarui.');
    }

    public function render()
    {
        $q = User::query()
            ->where('role', 'customer') // hanya customer
            ->when($this->search !== '', function ($query) {
                $query->where(function ($sub) {
                    $sub->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->latest();

        return view('livewire.admin.customers-index', [
            'customers' => $q->paginate($this->perPage),
        ]);
    }
}
