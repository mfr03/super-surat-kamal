<?php

namespace App\Forms\Filaments;

use Filament\Forms;
use Filament\Tables;
use App\Common;
use App\Common\CustomComponents;
use App\Models\Warga;
use \Illuminate\Support\Str;
use App\Constants\FormsConst;

class JenazahForms
{
    public static function form(): array
    {
        return [

                Forms\Components\Section::make('Data Jenazah')
                ->collapsible()
                ->schema([
                    CustomComponents::searchSelect(
                        'jenazah_id', 'Nama Jenazah',
                        'nama', 'Masukkan Nama Jenazah',
                        Warga::class, WargaForms::fieldMap(FormsConst::JENAZAH),
                        fn () => WargaForms::fields(false, FormsConst::JENAZAH),
                        fn (array $data) => Warga::create(
                            collect($data)
                            ->mapWithKeys(fn ($value, $key) => [Str::after($key, FormsConst::JENAZAH) => $value])
                            ->all()
                        )->getKey(),
                        function ($state, $set) {
                            $jenazah = \App\Models\Jenazah::where('warga_id', $state)->first();
                            if ($jenazah) {
                                $set('anak_ke', $jenazah->anak_ke);
                                $set('tanggal_kematian', $jenazah->tanggal_kematian);
                                $set('pukul_kematian', $jenazah->pukul_kematian);
                                $set('sebab_kematian', $jenazah->sebab_kematian);
                                $set('tempat_kematian', $jenazah->tempat_kematian);
                                $set('yang_menerangkan', $jenazah->yang_menerangkan);
                            } else {
                                // Optionally clear fields if no Jenazah found
                                $set('anak_ke', null);
                                $set('tanggal_kematian', null);
                                $set('pukul_kematian', null);
                                $set('sebab_kematian', null);
                                $set('tempat_kematian', null);
                                $set('yang_menerangkan', null);
                            }
                        }
                    )
                    ->afterStateUpdated(function ($state, $set) {
                        $jenazah = \App\Models\Jenazah::where('warga_id', $state)->first();
                        if ($jenazah) {
                            $set('anak_ke', $jenazah->anak_ke);
                            $set('tanggal_kematian', $jenazah->tanggal_kematian);
                            $set('pukul_kematian', $jenazah->pukul_kematian);
                            $set('sebab_kematian', $jenazah->sebab_kematian);
                            $set('tempat_kematian', $jenazah->tempat_kematian);
                            $set('yang_menerangkan', $jenazah->yang_menerangkan);
                        } else {
                            // Optionally clear fields if no Jenazah found
                            $set('anak_ke', null);
                            $set('tanggal_kematian', null);
                            $set('pukul_kematian', null);
                            $set('sebab_kematian', null);
                            $set('tempat_kematian', null);
                            $set('yang_menerangkan', null);
                        }
                    }),
                    ...WargaForms::fieldsUnique(true, false, FormsConst::JENAZAH)
                ]),
                
                Forms\Components\Section::make('Detail Jenazah')
                ->collapsible()
                ->schema([
                Forms\Components\TextInput::make('anak_ke')
                    ->required()
                    ->maxLength(255),

                Forms\Components\DatePicker::make('tanggal_kematian')
                    ->label('Tanggal Kematian')
                    ->native(false)
                    ->displayFormat('d F Y')
                    ->closeOnDateSelection()
                    ->required(),

                Forms\Components\TimePicker::make('pukul_kematian')
                    ->label('Pukul Kematian')
                    ->seconds(false)
                    ->format('H:i')
                    ->required(),

                Forms\Components\TextInput::make('sebab_kematian')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('tempat_kematian')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('yang_menerangkan')
                    ->required()
                    ->maxLength(255),
                    
                ]),
        ];
    }

    public static function table(): array
    {
        return [
                Tables\Columns\TextColumn::make('warga_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('anak_ke')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_kematian')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pukul_kematian')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sebab_kematian')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_kematian')
                    ->searchable(),
                Tables\Columns\TextColumn::make('yang_menerangkan')
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