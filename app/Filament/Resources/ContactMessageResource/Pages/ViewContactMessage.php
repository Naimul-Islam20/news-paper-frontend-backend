<?php

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactMessageResource::class;

    public function mount(int | string $record): void
    {
        parent::mount($record);

        /** @var \App\Models\ContactMessage $contactMessage */
        $contactMessage = $this->getRecord();

        if ($contactMessage->status === 'unread') {
            $contactMessage->update([
                'status' => 'read',
            ]);
        }
    }
}
