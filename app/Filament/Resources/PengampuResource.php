<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengampuResource\Pages;
use App\Filament\Resources\PengampuResource\RelationManagers;
use App\Models\Pengampu;
use App\Models\User;
use App\Models\MataPelajaran; // Jangan lupa import ini
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PengampuResource extends Resource
{
    protected static ?string $model = Pengampu::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // 1. Pilih Guru
                Forms\Components\Select::make('user_id')
                    ->label('Guru Pengampu')
                    ->options(User::where('role', 'guru')->pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                // 2. Pilih Kelas
                Forms\Components\Select::make('kelas_id')
                    ->relationship('kelas', 'nama_kelas')
                    ->label('Kelas')
                    ->searchable()
                    ->preload()
                    ->required(),

                // 3. Pilih Mata Pelajaran (YANG BARU: MULTIPLE)
                Forms\Components\Select::make('mata_pelajaran_ids') // Nama kolom harus plural (_ids)
                    ->label('Mata Pelajaran (Bisa Pilih Banyak)')
                    ->options(MataPelajaran::all()->pluck('nama_mapel', 'id')) // Ambil manual, jangan pakai relationship
                    ->multiple() // Fitur agar bisa pilih lebih dari 1
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Guru')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('kelas.nama_kelas')
                    ->label('Kelas')
                    ->sortable()
                    ->searchable(),

                // 4. Kolom Mapel (YANG BARU: FORMAT JSON)
                Tables\Columns\TextColumn::make('mata_pelajaran_ids')
                    ->label('Mapel Diampu')
                    ->formatStateUsing(function ($state) {
                        // JAGA-JAGA: Jika Model lupa di-cast, kita paksa decode manual
                        if (is_string($state)) {
                            $state = json_decode($state, true);
                        }

                        // Jika masih bukan array atau kosong, kembalikan strip
                        if (!is_array($state) || empty($state)) {
                            return '-';
                        }

                        return MataPelajaran::whereIn('id', $state)
                            ->pluck('nama_mapel')
                            ->join(', ');
                    })
                    ->wrap(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kelas_id')
                    ->relationship('kelas', 'nama_kelas')
                    ->label('Filter Kelas'),

                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Filter Guru')
                    ->options(User::where('role', 'guru')->pluck('name', 'id')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengampus::route('/'),
            'create' => Pages\CreatePengampu::route('/create'),
            'edit' => Pages\EditPengampu::route('/{record}/edit'),
        ];
    }
}
