<?php

namespace App\Forms\Filaments;

use Filament\Forms;
use Filament\Tables;
use App\Common;
use App\Common\CustomComponents;
use App\Models\Warga;
use \Illuminate\Support\Str;
use App\Constants\FormsConst;
use App\Models\Jenazah;

class JenazahForms
{
    public static function form(): array
    {
        return [

                Forms\Components\Section::make('Data Jenazah')
                ->collapsible()
                ->schema([
                    CustomComponents::searchSelect(
                        'warga_id', 'Nama Jenazah',
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

    public static function formUnique(string $relationField = 'jenazah_id'): array
    {
        return [

                Forms\Components\Section::make('Data Jenazah')
                ->collapsible()
                ->schema([
                    CustomComponents::searchSelect(
                        $relationField, 'Nama Jenazah',
                        'warga.nama', 'Masukkan Nama Jenazah',
                        Jenazah::class, WargaForms::fieldMap(FormsConst::JENAZAH),
                        fn () => [
                            ...WargaForms::fields(false, FormsConst::JENAZAH),
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
                        ],
                        function (array $data) {
                            $wargaData = collect($data)
                                ->filter(fn($v, $k) => Str::startsWith($k, FormsConst::JENAZAH))
                                ->mapWithKeys(fn($v, $k) => [Str::after($k, FormsConst::JENAZAH) => $v])
                                ->all();
                            $warga = Warga::create($wargaData);

                            $jenazahData = [
                                'warga_id' => $warga->id,
                                'anak_ke' => $data['anak_ke'] ?? null,
                                'tanggal_kematian' => $data['tanggal_kematian'] ?? null,
                                'pukul_kematian' => $data['pukul_kematian'] ?? null,
                                'sebab_kematian' => $data['sebab_kematian'] ?? null,
                                'tempat_kematian' => $data['tempat_kematian'] ?? null,
                                'yang_menerangkan' => $data['yang_menerangkan'] ?? null,
                            ];
                            $jenazah = Jenazah::create($jenazahData);

                            return $jenazah->id;
                        },
                        function ($state, $set) {
                            $jenazah = Jenazah::with('warga')->find($state);
                            if ($jenazah) {
                                $set('anak_ke', $jenazah->anak_ke);
                                $set('tanggal_kematian', $jenazah->tanggal_kematian);
                                $set('pukul_kematian', $jenazah->pukul_kematian);
                                $set('sebab_kematian', $jenazah->sebab_kematian);
                                $set('tempat_kematian', $jenazah->tempat_kematian);
                                $set('yang_menerangkan', $jenazah->yang_menerangkan);

                                foreach (WargaForms::fieldMap(FormsConst::JENAZAH) as $wargaKey => $formField) {
                                    $set($formField, $jenazah->warga->$wargaKey ?? null);
                                }
                            } else {
                                $set('anak_ke', null);
                                $set('tanggal_kematian', null);
                                $set('pukul_kematian', null);
                                $set('sebab_kematian', null);
                                $set('tempat_kematian', null);
                                $set('yang_menerangkan', null);

                                foreach (WargaForms::fieldMap(FormsConst::JENAZAH) as $formField) {
                                    $set($formField, null);
                                }
                            }
                        }
                    )
                    ->afterStateUpdated(function ($state, $set) {
                        $jenazah = Jenazah::with('warga')->find($state);
                        if ($jenazah) {
                            $set('anak_ke', $jenazah->anak_ke);
                            $set('tanggal_kematian', $jenazah->tanggal_kematian);
                            $set('pukul_kematian', $jenazah->pukul_kematian);
                            $set('sebab_kematian', $jenazah->sebab_kematian);
                            $set('tempat_kematian', $jenazah->tempat_kematian);
                            $set('yang_menerangkan', $jenazah->yang_menerangkan);

                            foreach (WargaForms::fieldMap(FormsConst::JENAZAH) as $wargaKey => $formField) {
                                $set($formField, $jenazah->warga->$wargaKey ?? null);
                            }
                        } else {
                            $set('anak_ke', null);
                            $set('tanggal_kematian', null);
                            $set('pukul_kematian', null);
                            $set('sebab_kematian', null);
                            $set('tempat_kematian', null);
                            $set('yang_menerangkan', null);

                            foreach (WargaForms::fieldMap(FormsConst::JENAZAH) as $formField) {
                                $set($formField, null);
                            }
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
            Tables\Columns\TextColumn::make('warga.nama')
                ->label('Nama Jenazah')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('anak_ke')
                ->label('Anak Ke')
                ->sortable(),

            Tables\Columns\TextColumn::make('tanggal_kematian')
                ->label('Tanggal Kematian')
                ->date('d F Y')
                ->sortable(),

            Tables\Columns\TextColumn::make('pukul_kematian')
                ->label('Pukul Kematian')
                ->sortable(),

            Tables\Columns\TextColumn::make('sebab_kematian')
                ->label('Sebab Kematian')
                ->limit(30)
                ->sortable(),

            Tables\Columns\TextColumn::make('tempat_kematian')
                ->label('Tempat Kematian')
                ->limit(30)
                ->sortable(),

            Tables\Columns\TextColumn::make('yang_menerangkan')
                ->label('Yang Menerangkan')
                ->limit(30)
                ->sortable(),
        ];
    }
}