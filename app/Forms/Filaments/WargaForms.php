<?php

namespace App\Forms\Filaments;

use Filament\Forms;
use Filament\Tables;
class WargaForms
{
    public static function form(bool $married = false): array
    {
        return [
            Forms\Components\Section::make('Form Data Warga')
            ->description('Masukkan Data-data Warga')
            ->schema(self::fields($married))
        ];
    }

    public static function fields(bool $married, string $prefix = '') : array
    {
        return [

                Forms\Components\TextInput::make($prefix . 'nama')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make($prefix. 'nik')
                    ->label('NIK')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make($prefix .'jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan'
                    ])
                    ->required(),

                Forms\Components\Grid::make(2)->schema([ 
                    Forms\Components\DatePicker::make($prefix . 'tanggal_lahir')
                        ->label('Tanggal Lahir')
                        ->native(false)
                        ->format('Y-m-d')
                        ->displayFormat('d F Y')
                        ->closeOnDateSelection()
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) use ($prefix) {
                            $birthDate = new \DateTime($state);
                            $today = new \DateTime();
                            $age = $today->diff($birthDate)->y;
                            $set($prefix . 'umur', $age);
                        }),
                    Forms\Components\TextInput::make($prefix.'umur')
                        ->label('Umur')
                        ->numeric()
                        ->disabled(true), 
                ]),

                Forms\Components\TextInput::make($prefix .'tempat_lahir')
                    ->label('Tempat Lahir')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make($prefix .'agama')
                    ->label('Agama yang Dianut')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make($prefix .'pekerjaan')
                    ->label('Pekerjaan yang Dimiliki')
                    ->maxLength(255),

                Forms\Components\TextInput::make($prefix.'alamat')
                    ->label('Alamat Domisili')
                    ->maxLength(255),

                Forms\Components\TextInput::make($prefix.'nomor_hp')
                    ->label('Nomor HP')
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make($prefix.'kartu_keluarga')
                    ->label('Nomor Kartu Keluarga')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make($prefix.'desa-kelurahan')
                    ->label('Desa Domisili')
                    ->maxLength(255)
                    ->required(),

                Forms\Components\TextInput::make($prefix.'kecamatan')
                    ->label('Kecamatan Domisili')
                    ->maxLength(255)
                    ->required(),

                Forms\Components\TextInput::make($prefix.'kabupaten')
                    ->label('Kabupaten Domisili')
                    ->maxLength(255)
                    ->required(),

                Forms\Components\TextInput::make($prefix.'provinsi')
                    ->label('Provinsi Domisili')
                    ->maxLength(255)
                    ->required(),

                Forms\Components\Select::make($prefix.'kewarganegaraan')
                    ->label('kewarganegaraan')
                    ->options([
                        'WNI' => 'WNI',
                        'WNA' => 'WNA',
                    ])
                    ->required(),

                Forms\Components\TextInput::make($prefix.'kebangsaan')
                    ->label('Kebangsaan')
                    ->maxLength(255)
                    ->required(),
                
                
                Forms\Components\DatePicker::make($prefix.'tanggal_pencatatan_perkawinan')
                    ->label('Tanggal Pencatatan Perkawinan')
                    ->displayFormat('d F Y')
                    ->closeOnDateSelection()
                    ->hidden($married != true),
                    
        ];
    }

    public static function fieldsUnique(bool $isDisabled, bool $married, string $prefix = ''): array
    {
        return [
                Forms\Components\TextInput::make($prefix.'nik')
                    ->label('NIK')
                    ->required()
                    ->maxLength(255)
                    ->disabled($isDisabled),

                Forms\Components\Select::make($prefix.'jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan'
                    ])
                    ->disabled($isDisabled)
                    ->required(),

                Forms\Components\Grid::make(2)->schema([ 
                    Forms\Components\DatePicker::make($prefix.'tanggal_lahir')
                        ->label('Tanggal Lahir')
                        ->native(false)
                        ->format('Y-m-d')
                        ->displayFormat('d F Y')
                        ->closeOnDateSelection()
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) use ($prefix) {
                            $birthDate = new \DateTime($state);
                            $today = new \DateTime();
                            $age = $today->diff($birthDate)->y;
                            $set( $prefix . 'umur', $age);
                        })
                        ->disabled($isDisabled),
                    Forms\Components\TextInput::make($prefix.'umur')
                        ->label('Umur')
                        ->numeric()
                        ->disabled(true), 
                ]),

                Forms\Components\TextInput::make($prefix.'tempat_lahir')
                    ->label('Tempat Lahir')
                    ->required()
                    ->maxLength(255)
                    ->disabled($isDisabled),

                Forms\Components\TextInput::make($prefix.'agama')
                    ->label('Agama yang Dianut')
                    ->required()
                    ->maxLength(255)
                    ->disabled($isDisabled),
                    
                Forms\Components\TextInput::make($prefix.'pekerjaan')
                    ->label('Pekerjaan yang Dimiliki')
                    ->maxLength(255)
                    ->disabled($isDisabled),

                Forms\Components\TextInput::make($prefix.'alamat')
                    ->label('Alamat Domisili')
                    ->required()
                    ->maxLength(255)
                    ->disabled($isDisabled),

                Forms\Components\TextInput::make($prefix.'nomor_hp')
                    ->label('Nomor HP')
                    ->maxLength(255)
                    ->disabled($isDisabled),

                Forms\Components\TextInput::make($prefix.'kartu_keluarga')
                    ->label('Nomor Kartu Keluarga')
                    ->maxLength(255)
                    ->disabled($isDisabled),

                Forms\Components\TextInput::make($prefix.'desa-kelurahan')
                    ->label('Desa Domisili')
                    ->maxLength(255)
                    ->required()
                    ->disabled($isDisabled),

                Forms\Components\TextInput::make($prefix.'kecamatan')
                    ->label('Kecamatan Domisili')
                    ->maxLength(255)
                    ->required()
                    ->disabled($isDisabled),

                Forms\Components\TextInput::make($prefix.'kabupaten')
                    ->label('Kabupaten Domisili')
                    ->maxLength(255)
                    ->required()
                    ->disabled($isDisabled),

                Forms\Components\TextInput::make($prefix.'provinsi')
                    ->label('Provinsi Domisili')
                    ->maxLength(255)
                    ->required()
                    ->disabled($isDisabled),

                Forms\Components\Select::make($prefix.'kewarganegaraan')
                    ->label('Kewarganegaraan')
                    ->options([
                        'WNI' => 'WNI',
                        'WNA' => 'WNA',
                    ])
                    ->required()
                    ->disabled($isDisabled),

                Forms\Components\TextInput::make($prefix.'kebangsaan')
                    ->label('Kebangsaan')
                    ->maxLength(255)
                    ->required()
                    ->disabled($isDisabled),
                
                
                Forms\Components\DatePicker::make($prefix.'tanggal_pencatatan_perkawinan')
                    ->label('Tanggal Pencatatan Perkawinan')
                    ->displayFormat('d F Y')
                    ->closeOnDateSelection()
                    ->hidden($married != true)
                    ->required(),
                    

        ];
    }

    public static function fieldMap(string $prefix = ''): array
    {
        return [
            'nik' => $prefix . 'nik',
            'nama' => $prefix . 'nama',
            'jenis_kelamin' => $prefix . 'jenis_kelamin',
            'tanggal_lahir' => $prefix . 'tanggal_lahir',
            'tempat_lahir' => $prefix . 'tempat_lahir',
            'agama' => $prefix . 'agama',
            'pekerjaan' => $prefix . 'pekerjaan',
            'kartu_keluarga' => $prefix . 'kartu_keluarga',
            'alamat' => $prefix . 'alamat',
            'nomor_hp'=> $prefix . 'nomor_hp',
            'desa-kelurahan' => $prefix . 'desa-kelurahan',
            'kecamatan' => $prefix . 'kecamatan',
            'kabupaten' => $prefix . 'kabupaten',
            'provinsi' => $prefix . 'provinsi',
            'kewarganegaraan' => $prefix . 'kewarganegaraan',
            'kebangsaan' => $prefix . 'kebangsaan',
            'tanggal_pencatatan_perkawinan' => $prefix . 'tanggal_pencatatan_perkawinan',
        ];
    }

    public static function table(): array
    {
        return [
                Tables\Columns\TextColumn::make('nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('agama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pekerjaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_hp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('desa-kelurahan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kecamatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kabupaten')
                    ->searchable(),
                Tables\Columns\TextColumn::make('provinsi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kewarganegaraan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kebangsaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_pencatatan_perkawinan')
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