<?php

namespace App\Forms\Filaments;

use Filament\Forms;
use Filament\Tables;

class BayiForms
{
    public static function form(): array
    {
        return [
            Forms\Components\Section::make('Form Data Bayi')
                ->description('Masukkan data-data bayi')
                ->schema(self::fields())
                ->collapsible()
        ];
    }

    public static function fields(): array
    {
        return [
            Forms\Components\TextInput::make('nama')
                ->label('Nama Bayi')
                ->required()
                ->maxLength(255),

            Forms\Components\Select::make('jenis_kelamin')
                ->label('Jenis Kelamin Bayi')
                ->options([
                    'Laki-laki' => 'Laki-laki',
                    'Perempuan' => 'Perempuan'
                ])
                ->required(),

            Forms\Components\Select::make('tempat_dilahirkan')
                ->label('Tempat Dilahirkan')
                ->options([
                    'Rumah Sakit' => 'Rumah sakit (RS)',
                    'Puskesmas' => 'Puskesmas',
                    'Polindes' => 'Polindes',
                    'Rumah' => 'Rumah',
                    'Lainnya' => 'Lainnya',
                ])
                ->required(),

            Forms\Components\TextInput::make('tempat_kelahiran')
                ->label('Tempat Kelahiran')
                ->required()
                ->maxLength(255),
            
            Forms\Components\DatePicker::make('tanggal_lahir')
                ->label('Tanggal Lahir Bayi')
                ->displayFormat('d F Y')
                ->format('Y-m-d')   
                ->closeOnDateSelection()
                ->required(),

            Forms\Components\TimePicker::make('pukul_lahir')
                ->label('Pukul Lahir')
                ->seconds(false)  
                ->format('H:i')  
                ->required(),

            Forms\Components\Select::make('jenis_kelahiran')
                ->label('Jenis Kelahiran')
                ->options([
                    'Tunggal' => 'Tunggal',
                    'Kembar 2' => 'Kembar 2',
                    'Kembar 3' => 'Kembar 3',
                    'Kembar 4' => 'Kembar 4',
                    'Lainnya' => 'Lainnya',
                ])
                ->required(),

                Forms\Components\Select::make('kelahiran_ke')
                    ->label('Kelahiran ke')
                    ->options([
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                        '7' => '7',
                        '8' => '8',
                        '9' => '9',
                        '10' => '10',
                        '11' => '11',
                        '12' => '12',
                        '13' => '13',
                    ])
                    ->required(),

            Forms\Components\Select::make('penolong_kelahiran')
                ->label('Penolong Kelahiran')
                ->options([
                    'Dokter' => 'Dokter',
                    'Bidan/Perawat' => 'Bidan/Perawat',
                    'Dukun' => 'Dukun',
                    'Lainnya' => 'Lainnya',
                ])
                ->required(),

            Forms\Components\TextInput::make('berat_bayi')
                ->label('Berat Bayi (kg)')
                ->numeric()
                ->required()
                ->step(0.01) 
                ->maxValue(10) 
                ->placeholder('2.5 kg'),

            Forms\Components\TextInput::make('panjang_bayi')
                ->label('Panjang Bayi (cm)')
                ->numeric()
                ->required()
                ->maxLength(5),
        ];
    }

    public static function formMinusName(bool $isDisabled): array
    {
        return [
            Forms\Components\Section::make('Form Data Bayi')
                ->description('Masukkan data-data bayi')
                ->schema(self::fieldsMinusName($isDisabled))
                ->collapsible()
        ];
    }

    public static function fieldsMinusName(bool $isDisabled): array
    {
        return [
            Forms\Components\Select::make('jenis_kelamin')
                ->label('Jenis Kelamin Bayi')
                ->options([
                    'Laki-laki' => 'Laki-laki',
                    'Perempuan' => 'Perempuan'
                ])
                ->disabled($isDisabled)
                ->required(),

            Forms\Components\Select::make('tempat_dilahirkan')
                ->label('Tempat Dilahirkan')
                ->options([
                    'Rumah Sakit' => 'Rumah sakit (RS)',
                    'Puskesmas' => 'Puskesmas',
                    'Polindes' => 'Polindes',
                    'Rumah' => 'Rumah',
                    'Lainnya' => 'Lainnya',
                ])
                ->disabled($isDisabled)
                ->required(),

            Forms\Components\TextInput::make('tempat_kelahiran')
                ->label('Tempat Kelahiran')
                ->disabled($isDisabled)
                ->required()
                ->maxLength(255),
            
            Forms\Components\DatePicker::make('tanggal_lahir')
                ->label('Tanggal Lahir Bayi')
                ->displayFormat('d F Y')
                ->format('Y-m-d')
                ->closeOnDateSelection()
                ->disabled($isDisabled)
                ->required(),

            Forms\Components\TimePicker::make('pukul_lahir')
                ->label('Pukul Lahir')
                ->seconds(false)  
                ->format('H:i')  
                ->disabled($isDisabled)
                ->required(),

            Forms\Components\Select::make('jenis_kelahiran')
                ->label('Jenis Kelahiran')
                ->options([
                    'Tunggal' => 'Tunggal',
                    'Kembar 2' => 'Kembar 2',
                    'Kembar 3' => 'Kembar 3',
                    'Kembar 4' => 'Kembar 4',
                    'Lainnya' => 'Lainnya',
                ])
                ->disabled($isDisabled)
                ->required(),

            Forms\Components\Select::make('kelahiran_ke')
                ->label('Kelahiran ke')
                ->options([
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10',
                    '11' => '11',
                    '12' => '12',
                    '13' => '13',
                ])
                ->disabled($isDisabled)
                ->required(),

            Forms\Components\Select::make('penolong_kelahiran')
                ->label('Penolong Kelahiran')
                ->options([
                    'Dokter' => 'Dokter',
                    'Bidan/Perawat' => 'Bidan/Perawat',
                    'Dukun' => 'Dukun',
                    'Lainnya' => 'Lainnya',
                ])
                ->disabled($isDisabled)
                ->required(),

            Forms\Components\TextInput::make('berat_bayi')
                ->label('Berat Bayi (kg)')
                ->numeric()
                ->disabled($isDisabled)
                ->required()
                ->step(0.01) 
                ->maxValue(10) 
                ->placeholder('2.5 kg'),

            Forms\Components\TextInput::make('panjang_bayi')
                ->label('Panjang Bayi (cm)')
                ->numeric()
                ->disabled($isDisabled)
                ->required()
                ->maxLength(5),
        ];
    }

    public static function fieldMapMinusName(): array
    {
        return [
            'jenis_kelamin' => 'jenis_kelamin',
            'tempat_dilahirkan' => 'tempat_dilahirkan',
            'tempat_kelahiran' => 'tempat_kelahiran',
            'tanggal_lahir' => 'tanggal_lahir',
            'pukul_lahir' => 'pukul_lahir',
            'jenis_kelahiran' => 'jenis_kelahiran',
            'kelahiran_ke' => 'kelahiran_ke',
            'penolong_kelahiran' => 'penolong_kelahiran',
            'berat_bayi' => 'berat_bayi',
            'panjang_bayi' => 'panjang_bayi',
        ];
    }




    public static function table(): array
    {
        return [
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_dilahirkan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_kelahiran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pukul_lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_kelahiran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kelahiran_ke')
                    ->searchable(),
                Tables\Columns\TextColumn::make('penolong_kelahiran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('berat_bayi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('panjang_bayi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}