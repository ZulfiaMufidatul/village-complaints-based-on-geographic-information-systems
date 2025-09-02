<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\FileUpload;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static bool $shouldRegisterNavigation = false;
    protected static string $view = 'filament.pages.edit-profile';
    protected static ?string $title = 'Edit Profil';

    public ?array $data = [];
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $avatar_url;

    public function mount(): void
    {
        $this->form->fill([
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'avatar_url' => Auth::user()->avatar_url,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            FileUpload::make('avatar_url')
                ->label('Foto Profil')
                ->image()
                ->imageEditor() // untuk crop dll
                ->directory('avatars') // simpan di storage/app/public/avatars
                ->maxSize(1024)
                ->nullable(),

            TextInput::make('name')
                ->label('Nama')
                ->required(),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->disabled()
                ->dehydrated(),

            TextInput::make('password')
                ->label('Password Baru')
                ->password()
                ->dehydrated(fn($state) => filled($state)) // hanya update jika diisi
                ->nullable(),

            TextInput::make('password_confirmation')
                ->label('Konfirmasi Password Baru')
                ->password()
                ->same('password')
                ->nullable(),
        ];
    }

    public function submit(): void
    {
        $user = Auth::user();

        $data = $this->form->getState();

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['avatar_url'])) {
            $user->avatar_url = $data['avatar_url'];
        }

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();
    }
}
