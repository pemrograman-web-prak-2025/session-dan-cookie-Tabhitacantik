@extends('layouts.app')

@section('title', 'Edit Tugas')

@section('content')
<div class="form-container">
    <div class="form-card">
        <h2>Edit Tugas</h2>
        
        <form action="{{ route('tugas.update', $tugas->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="judul">Judul Tugas *</label>
                <input type="text" id="judul" name="judul" class="form-control" value="{{ old('judul', $tugas->judul) }}" required>
                @error('judul')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $tugas->deskripsi) }}</textarea>
                @error('deskripsi')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="deadline">Deadline *</label>
                <input type="date" id="deadline" name="deadline" class="form-control" value="{{ old('deadline', $tugas->deadline->format('Y-m-d')) }}" required>
                @error('deadline')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status *</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="Belum Selesai" {{ old('status', $tugas->status) === 'Belum Selesai' ? 'selected' : '' }}>Belum Selesai</option>
                    <option value="Selesai" {{ old('status', $tugas->status) === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                @error('status')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('home') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection