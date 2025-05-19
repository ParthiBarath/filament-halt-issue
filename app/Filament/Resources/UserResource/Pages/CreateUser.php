<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Hash;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected ?bool $hasDatabaseTransactions = true;

    protected function handleRecordCreation(array $data): Model {
        $inputData = $data;
        $inputData['password'] = Hash::make(123456);

        $record = static::getModel()::create($inputData);

        if (empty($inputData['email'])) {
            $this->halt(); // This line doesn't rollback the database transaction

            // throw (new Halt)->rollBackDatabaseTransaction();  // Alternatively using this one to rollback the database transaction
        }

        return $record;
    }
}
