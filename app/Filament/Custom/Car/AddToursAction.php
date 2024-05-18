<?php

namespace App\Filament\Custom\Car;

use Filament\Forms\Form;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\Action;

class AddToursAction extends Action
{

    protected function setUp(): void
    {
        $this->label('Tambah Tour')
            ->form([
                TextInput::make('name')
                    ->label('Nama Tour')
                    ->required(),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->required(),
                // Tambahkan lebih banyak komponen form sesuai kebutuhan
            ])
            ->modalHeading('Tambah Tour Baru')
            ->action('save');
    }

    public function save(Form $form)
    {
        $data = $form->getState();

        // Logika untuk menyimpan data tour
        // Misalnya, menggunakan model Tour
        // Tour::create($data);

        $this->success('Tour berhasil ditambahkan.');
        $this->redirect('/path-to-redirect');
    }
}
